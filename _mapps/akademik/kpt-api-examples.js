/**
 * KPT SKPG API - Implementation Examples
 * 
 * This file demonstrates various ways to use the client-side API
 */

// ============================================================================
// EXAMPLE 1: Basic API Call
// ============================================================================

// Get raw API response for a specific IC
function example1_basicApiCall() {
    const no_kp = '940107075505';
    
    callKptSkpgApi(no_kp).then(response => {
        console.log('API Response:', response);
        
        if (response.success) {
            console.log('HTTP Code:', response.http_code);
            console.log('Data:', response.data);
        } else {
            console.error('API Error:', response.error);
        }
    });
}

// ============================================================================
// EXAMPLE 2: Complete Data Mapping Workflow
// ============================================================================

// Full workflow with mapping
function example2_completeWorkflow() {
    const no_kp = '940107075505';
    
    fetchAndMapUniversityData(no_kp).then(result => {
        if (result.status === 'OK') {
            console.log('Mapped Data:', result.data);
            
            // Access individual fields
            result.data.forEach(univ => {
                console.log('Year:', univ.tahun);
                console.log('Institution Code:', univ.inst_kod);
                console.log('Institution Name:', univ.inst_nama);
                console.log('Program Code:', univ.khusus_kod);
                console.log('Program Name:', univ.khusus_nama);
                console.log('CGPA:', univ.cgpa);
            });
        } else {
            console.error('Error:', result.msg);
        }
    }).catch(error => {
        console.error('Exception:', error);
    });
}

// ============================================================================
// EXAMPLE 3: Get Institution Mappings
// ============================================================================

// Fetch and display all institution mappings
function example3_institutionMappings() {
    fetchInstitutionMapping().then(instMap => {
        console.log('Institution Mappings:', instMap);
        
        // Example output:
        // {
        //   "UNIV001": { kod: "UNI001", nama: "University Malaysia" },
        //   "UNIV002": { kod: "UNI002", nama: "Polytechnic Kuala Lumpur" }
        // }
        
        // Iterate and display
        Object.keys(instMap).forEach(apiCode => {
            console.log(`API: ${apiCode} → Local: ${instMap[apiCode].kod} (${instMap[apiCode].nama})`);
        });
    });
}

// ============================================================================
// EXAMPLE 4: Get Course Mappings
// ============================================================================

// Fetch and display all course mappings
function example4_courseMappings() {
    fetchCourseMapping().then(courseMap => {
        console.log('Course Mappings:', courseMap);
        
        // Example output:
        // {
        //   "CS001": { kod: "PROG001", nama: "Bachelor of Computer Science" },
        //   "ME001": { kod: "PROG002", nama: "Bachelor of Mechanical Engineering" }
        // }
    });
}

// ============================================================================
// EXAMPLE 5: Manual Data Mapping
// ============================================================================

// Manually map API data with custom mappings
function example5_manualMapping() {
    const apiData = {
        success: true,
        data: {
            data: [
                {
                    end_date: '2024-12-31',
                    level_course_id: '1',
                    CGPA: '3.75',
                    id_univ: 'UNIV001',
                    univ_long: 'University Malaysia',
                    course_code: 'CS001',
                    course_long: 'Bachelor of Computer Science'
                }
            ]
        }
    };
    
    const instMap = {
        'UNIV001': { kod: 'UNI001', nama: 'University Malaysia' }
    };
    
    const courseMap = {
        'CS001': { kod: 'PROG001', nama: 'Bachelor of Computer Science' }
    };
    
    const mapped = mapKptApiData(apiData.data.data, instMap, courseMap);
    console.log('Manually Mapped Data:', mapped);
}

// ============================================================================
// EXAMPLE 6: Error Handling
// ============================================================================

// Comprehensive error handling
function example6_errorHandling() {
    const no_kp = '940107075505';
    
    fetchAndMapUniversityData(no_kp)
        .then(result => {
            if (result.status === 'OK') {
                console.log('Success:', result.data);
            } else if (result.status === 'ERR') {
                console.error('API Error:', result.msg);
                
                // Handle specific error types
                if (result.msg.includes('Failed to connect')) {
                    console.error('Network error - API server unreachable');
                    // Show user message and allow manual entry
                } else if (result.msg.includes('Tiada data')) {
                    console.warn('No data found for this IC');
                    // Allow user to search again or enter manually
                } else if (result.msg.includes('mapping')) {
                    console.error('Data mapping error - check database');
                }
            }
        })
        .catch(error => {
            console.error('Unexpected error:', error.message);
            // Log to monitoring service
        });
}

// ============================================================================
// EXAMPLE 7: Form Filling with Timeout
// ============================================================================

// Fill form fields with timeout protection
function example7_formFillingWithTimeout() {
    const no_kp = '940107075505';
    const timeoutMs = 30000; // 30 seconds
    
    const timeoutPromise = new Promise((resolve, reject) => {
        setTimeout(() => reject(new Error('Request timeout')), timeoutMs);
    });
    
    Promise.race([
        fetchAndMapUniversityData(no_kp),
        timeoutPromise
    ])
    .then(result => {
        if (result.status === 'OK' && result.data.length > 0) {
            const d = result.data[0];
            
            // Fill form elements
            document.getElementById('tahun1').value = d.tahun;
            document.getElementById('tkh_senate').value = d.tkh_senate;
            document.getElementById('peringkat1').value = d.peringkat;
            document.getElementById('cgpa1').value = d.cgpa;
            document.getElementById('inst_keluar_sijil1').value = d.inst_kod;
            document.getElementById('pengkhususan1').value = d.khusus_kod;
            
            console.log('Form filled successfully');
        }
    })
    .catch(error => {
        console.error('Failed to fetch data within timeout:', error.message);
    });
}

// ============================================================================
// EXAMPLE 8: Multiple IC Lookups
// ============================================================================

// Fetch data for multiple students
function example8_batchLookup() {
    const icNumbers = [
        '940107075505',
        '950208076006',
        '960309077007'
    ];
    
    const promises = icNumbers.map(no_kp => 
        fetchAndMapUniversityData(no_kp)
    );
    
    Promise.all(promises)
        .then(results => {
            results.forEach((result, index) => {
                const no_kp = icNumbers[index];
                
                if (result.status === 'OK') {
                    console.log(`${no_kp}: Found data for ${result.data.length} university entry`);
                } else {
                    console.warn(`${no_kp}: ${result.msg}`);
                }
            });
        })
        .catch(error => {
            console.error('Batch lookup failed:', error);
        });
}

// ============================================================================
// EXAMPLE 9: Caching Implementation
// ============================================================================

// Simple in-memory cache for API responses
const apiCache = new Map();
const CACHE_TTL = 5 * 60 * 1000; // 5 minutes

function example9_caching() {
    
    async function fetchWithCache(no_kp) {
        const cacheKey = `univ_${no_kp}`;
        const cached = apiCache.get(cacheKey);
        
        // Check if cache exists and is not expired
        if (cached && Date.now() - cached.timestamp < CACHE_TTL) {
            console.log('Returning cached data');
            return cached.data;
        }
        
        // Fetch fresh data
        const result = await fetchAndMapUniversityData(no_kp);
        
        // Cache the result
        apiCache.set(cacheKey, {
            data: result,
            timestamp: Date.now()
        });
        
        console.log('Data cached');
        return result;
    }
    
    // Usage
    fetchWithCache('940107075505').then(result => {
        console.log('Result:', result);
    });
    
    // Second call within 5 minutes will use cache
    setTimeout(() => {
        fetchWithCache('940107075505').then(result => {
            console.log('Result (cached):', result);
        });
    }, 1000);
}

// ============================================================================
// EXAMPLE 10: Integration with jQuery/AJAX
// ============================================================================

// Save mapped data to server
function example10_saveToServer() {
    const no_kp = '940107075505';
    
    fetchAndMapUniversityData(no_kp).then(result => {
        if (result.status === 'OK') {
            // Save to server
            $.ajax({
                url: 'akademik/sql_akademik.php?frm=UNIV&pro=SAVE',
                type: 'POST',
                data: {
                    id_pemohon: $('#id_pemohon').val(),
                    tahun: result.data[0].tahun,
                    tkh_senate: result.data[0].tkh_senate,
                    peringkat: result.data[0].peringkat,
                    cgpa: result.data[0].cgpa,
                    inst_kod: result.data[0].inst_kod,
                    khusus_kod: result.data[0].khusus_kod,
                    is_api_data: '1'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'OK') {
                        console.log('Data saved successfully');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Save failed:', error);
                }
            });
        }
    });
}

// ============================================================================
// UTILITY: Debug Helper
// ============================================================================

// Log all API operations
function debugApiCalls() {
    const originalFetch = window.fetch;
    
    window.fetch = function(...args) {
        console.log('[API CALL]', {
            url: args[0],
            options: args[1],
            timestamp: new Date().toISOString()
        });
        
        return originalFetch.apply(this, args)
            .then(response => {
                console.log('[API RESPONSE]', {
                    status: response.status,
                    ok: response.ok,
                    url: response.url
                });
                return response;
            })
            .catch(error => {
                console.error('[API ERROR]', {
                    message: error.message,
                    stack: error.stack
                });
                throw error;
            });
    };
}

// ============================================================================
// Run Examples (Uncomment to test)
// ============================================================================

/*
example1_basicApiCall();
example2_completeWorkflow();
example3_institutionMappings();
example4_courseMappings();
example6_errorHandling();
example9_caching();
example10_saveToServer();

// Enable debugging
debugApiCalls();
*/
