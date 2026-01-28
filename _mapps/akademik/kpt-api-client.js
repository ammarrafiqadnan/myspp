/**
 * KPT SKPG API Client (JavaScript)
 * Handles API calls from client-side to avoid server firewall blockage
 */

/**
 * Fetch JSON with timeout support
 * @param {string} url - Request URL
 * @param {Object} options - Fetch options
 * @param {number} timeoutMs - Timeout in milliseconds
 * @returns {Promise<{response: Response, data: any}>}
 */
async function fetchJsonWithTimeout(url, options, timeoutMs) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), timeoutMs);
    
    try {
        const response = await fetch(url, {
            ...options,
            signal: controller.signal
        });
        const data = await response.json().catch(() => null);
        return { response, data };
    } finally {
        clearTimeout(timeoutId);
    }
}

/**
 * Call KPT SKPG API to fetch university data
 * @param {string} no_kp - No Kad Pengenalan (IC Number)
 * @returns {Promise} - API response with success status, data, and HTTP code
 */
async function callKptSkpgApi(no_kp) {
    const url = 'http://10.29.53.228/api/kpt/skpg';
    const token = 'I4ITysnunS2qUw0qHc1hu14bO70WAT8Q7te9QnBJ23fdd7cb';
    
    const payload = {
        no_kp: no_kp
    };
    
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + token
    };
    
    try {
        // Primary attempt: POST with JSON body
        let result = await fetchJsonWithTimeout(url, {
            method: 'POST',
            headers,
            body: JSON.stringify(payload)
        }, 60000);
        
        // Fallback: some APIs only accept GET
        if (result.response.status === 400 || result.response.status === 405) {
            const getUrl = url + '?no_kp=' + encodeURIComponent(no_kp);
            result = await fetchJsonWithTimeout(getUrl, {
                method: 'GET',
                headers
            }, 60000);
        }
        
        return {
            success: result.response.ok,
            data: result.data,
            http_code: result.response.status
        };
    } catch (error) {
        return {
            success: false,
            data: null,
            error: error.message
        };
    }
}

/**
 * Map KPT API response to local system format
 * @param {Array} apiDataArray - Array of university records from API
 * @param {Object} institutionMap - Map of API institution codes to local codes
 * @param {Object} courseMap - Map of API course codes to local codes
 * @returns {Array} - Mapped data in local system format
 */
function mapKptApiData(apiDataArray, institutionMap = {}, courseMap = {}) {
    if (!Array.isArray(apiDataArray)) {
        return [];
    }
    
    const mappedList = [];
    
    apiDataArray.forEach(row => {
        const mappedRow = {};
        
        // 1. Tahun (Extract from end_date)
        mappedRow.tahun = (row.end_date) ? new Date(row.end_date).getFullYear().toString() : '';
        
        // 2. Tarikh Senat (Format DD/MM/YYYY)
        if (row.end_date) {
            const dateObj = new Date(row.end_date);
            const day = String(dateObj.getDate()).padStart(2, '0');
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const year = dateObj.getFullYear();
            mappedRow.tkh_senate = `${day}/${month}/${year}`;
        } else {
            mappedRow.tkh_senate = '';
        }
        
        // 3. Peringkat
        mappedRow.peringkat = row.level_course_id || '';
        
        // 4. CGPA
        mappedRow.cgpa = row.CGPA || '';
        
        // 5. Institusi (Using provided map or API value as fallback)
        const apiInstId = row.id_univ;
        if (institutionMap[apiInstId]) {
            mappedRow.inst_kod = institutionMap[apiInstId].kod;
            mappedRow.inst_nama = institutionMap[apiInstId].nama;
        } else {
            mappedRow.inst_kod = '';
            mappedRow.inst_nama = row.univ_long || '';
        }
        
        // 6. Nama Sijil / Pengkhususan (Using provided map or API value as fallback)
        const courseCodeApi = row.course_code;
        if (courseMap[courseCodeApi]) {
            mappedRow.khusus_kod = courseMap[courseCodeApi].kod;
            mappedRow.khusus_nama = courseMap[courseCodeApi].nama;
        } else {
            mappedRow.khusus_kod = '';
            mappedRow.khusus_nama = row.course_long || '';
        }
        
        mappedList.push(mappedRow);
    });
    
    return mappedList;
}

/**
 * Fetch institution mapping from local database
 * This should be called from the server and cached
 * @returns {Promise} - Map of API institution codes to local codes
 */
async function fetchInstitutionMapping() {
    try {
        const response = await fetch('api-mapping.php?action=get_institution_map');
        return await response.json();
    } catch (error) {
        console.warn('Failed to fetch institution mapping:', error);
        return {};
    }
}

/**
 * Fetch course mapping from local database
 * This should be called from the server and cached
 * @returns {Promise} - Map of API course codes to local codes
 */
async function fetchCourseMapping() {
    try {
        const response = await fetch('api-mapping.php?action=get_course_map');
        return await response.json();
    } catch (error) {
        console.warn('Failed to fetch course mapping:', error);
        return {};
    }
}

/**
 * Complete workflow: Fetch API data and map to local format
 * @param {string} no_kp - IC Number
 * @returns {Promise} - Mapped university data
 */
async function fetchAndMapUniversityData(no_kp) {
    try {
        // Step 1: Fetch API data
        const apiResult = await callKptSkpgApi(no_kp);
        
        if (!apiResult.success) {
            return {
                status: 'ERR',
                msg: `API Error: ${apiResult.error || 'Failed to connect to API'}`
            };
        }
        
        // Step 2: Check if data exists
        if (!apiResult.data || !apiResult.data.data || !Array.isArray(apiResult.data.data)) {
            return {
                status: 'ERR',
                msg: 'Tiada data API dijumpai.'
            };
        }
        
        // Step 3: Fetch mappings
        const instMap = await fetchInstitutionMapping();
        const courseMap = await fetchCourseMapping();
        
        // Step 4: Map data
        const mappedData = mapKptApiData(apiResult.data.data, instMap, courseMap);
        
        if (mappedData.length === 0) {
            return {
                status: 'ERR',
                msg: 'Tiada data dapat dimapped.'
            };
        }
        
        return {
            status: 'OK',
            data: mappedData
        };
    } catch (error) {
        return {
            status: 'ERR',
            msg: `Error: ${error.message}`
        };
    }
}
