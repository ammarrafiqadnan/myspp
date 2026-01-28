# KPT SKPG API - Client-Side Migration

## Overview
Due to server firewall restrictions blocking access to the KPT SKPG API (`http://10.29.53.228/api/kpt/skpg`), the API call has been migrated from **server-side PHP** to **client-side JavaScript**.

## Files Created/Modified

### 1. **kpt-api-client.js** (NEW)
**Location:** `_mapps/akademik/kpt-api-client.js`

This JavaScript library provides:
- `callKptSkpgApi(no_kp)` - Fetch data from KPT SKPG API
- `mapKptApiData(apiDataArray, instMap, courseMap)` - Map API response to local database format
- `fetchInstitutionMapping()` - Get institution code mappings from server
- `fetchCourseMapping()` - Get course code mappings from server
- `fetchAndMapUniversityData(no_kp)` - Complete workflow function

### 2. **api-mapping.php** (NEW)
**Location:** `_mapps/akademik/api-mapping.php`

Server-side helper that provides mappings:
- **Action:** `get_institution_map` - Returns institution code mappings (API → Local)
- **Action:** `get_course_map` - Returns course/specialization code mappings (API → Local)
- Includes 1-hour caching to reduce database load

### 3. **univ1.php** (MODIFIED)
**Location:** `_mapps/akademik/univ1.php`

Changes:
- Added `<script src="akademik/kpt-api-client.js"></script>` to load JavaScript library
- Added hidden input: `<input type="hidden" id="sess_uic" value="<?=$_SESSION['SESS_UIC'];?>">`
- Updated `check_univ_integration_1()` function to use client-side API instead of AJAX to PHP

## How It Works

### Old Flow (Blocked by Firewall)
```
Client Browser
    ↓
univ1.php (AJAX to PHP)
    ↓
sql_akademik.php (Server calls KPT API)
    ↓ ❌ BLOCKED by Firewall
KPT SKPG API
```

### New Flow (Client-Side)
```
Client Browser
    ↓
univ1.php (JavaScript calls API directly)
    ↓
kpt-api-client.js (Client-side fetch)
    ↓
KPT SKPG API ✓ (Direct browser connection, bypasses server firewall)
    ↓
api-mapping.php (Get code mappings from server DB)
```

## Usage

### In Frontend (univ1.php)
The `check_univ_integration_1()` function automatically:
1. Gets IC number from session (`$_SESSION['SESS_UIC']`)
2. Calls `fetchAndMapUniversityData(no_ic)`
3. On success, fills and locks form fields with API data
4. On failure, silently allows manual entry

### Direct JavaScript Call
```javascript
// Fetch and map data in one call
fetchAndMapUniversityData('071201110395')
    .then(result => {
        if (result.status === 'OK') {
            console.log('Data:', result.data);
        } else {
            console.error('Error:', result.msg);
        }
    });

// Or use the raw API function
callKptSkpgApi('071201110395')
    .then(response => {
        console.log(response);
        // Handle raw API response
    });
```

## API Details

### KPT SKPG API Endpoint
- **URL:** `http://10.29.53.228/api/kpt/skpg`
- **Method:** GET
- **Headers:**
  - `Content-Type: application/json`
  - `Authorization: Bearer I4ITysnunS2qUw0qHc1hu14bO70WAT8Q7te9QnBJ23fdd7cb`
- **Body:** `{ "no_kp": "XXXXXXXXXX" }`
- **Timeout:** 60 seconds

### API Response Structure
```json
{
  "success": true,
  "data": {
    "data": [
      {
        "end_date": "2024-12-31",
        "level_course_id": "1",
        "CGPA": "3.75",
        "id_univ": "UNIV001",
        "univ_long": "University Name",
        "course_code": "CS001",
        "course_long": "Bachelor of Computer Science"
      }
    ]
  },
  "http_code": 200
}
```

### Mapped Response Structure
```json
{
  "tahun": "2024",
  "tkh_senate": "31/12/2024",
  "peringkat": "1",
  "cgpa": "3.75",
  "inst_kod": "UNI001",
  "inst_nama": "University Name",
  "khusus_kod": "PROG001",
  "khusus_nama": "Bachelor of Computer Science"
}
```

## Code Mappings

### Institution Mapping
Database query from `ref_institusi` table:
- Maps `KOD_INTEGRASI` (API code) → `KOD` (Local code) + `DISKRIPSI` (Name)
- Example: `"UNIV001"` → `{ kod: "UNI001", nama: "University Malaysia" }`

### Course/Specialization Mapping
Database queries from `ref_pengkhususan_kpt_padanan` + `ref_pengkhususan`:
- Maps `kod_kpt` (API code) → `kod_myspp` (Local code) + `DISKRIPSI` (Name)
- Example: `"CS001"` → `{ kod: "PROG001", nama: "Bachelor of Computer Science" }`

## Error Handling

### Network Errors
If client cannot connect to API:
```javascript
{
  "success": false,
  "data": null,
  "error": "NetworkError message"
}
```

### Mapping Failures
If code mapping not found, functions gracefully fall back to API values.

## Browser Compatibility

✓ Works in modern browsers supporting:
- `fetch()` API (ES6)
- `async/await`
- JSON
- Promise

⚠️ Does NOT work in:
- Internet Explorer (use polyfill or revert to AJAX approach)
- Browsers with Cross-Origin restrictions (if API has CORS enabled)

## CORS Considerations

If you get CORS errors, ensure:
1. **KPT API must support CORS** - The API server must have `Access-Control-Allow-Origin` headers
2. **If not available** - Use the PHP proxy method (keep the old code as fallback)
3. **Check Browser Console** for detailed CORS error messages

## Fallback Strategy

If client-side API fails:
- Form remains empty but **functional**
- User can **manually enter data**
- No exception/error shown to user (silent failure)
- Check browser console for debugging

## Testing

### Test in Browser Console
```javascript
// Test the API directly
callKptSkpgApi('940107075505').then(console.log);

// Test the full workflow
fetchAndMapUniversityData('940107075505').then(console.log);
```

### Test Code Mappings
```javascript
// Fetch mappings
fetchInstitutionMapping().then(map => console.log('Institutions:', map));
fetchCourseMapping().then(map => console.log('Courses:', map));
```

## Performance Notes

- **Caching:** Mappings are cached server-side for 1 hour (via `Cache-Control` headers)
- **Timeout:** API call times out after 60 seconds
- **No Polling:** One-time call on page load

## Security Notes

⚠️ **API Token is visible in client-side code!**

This may be a security concern if:
- The token should be kept secret
- The API has rate limiting

**Mitigation Options:**
1. **Keep token server-side** - Create a PHP endpoint that proxies the API call
2. **IP-based auth** - If API only allows specific IPs, client-side is safe
3. **Request signing** - Add request signatures in addition to token

## Troubleshooting

### API call fails silently
1. Check browser **Console** for errors
2. Verify IC number is correct
3. Check if KPT API is accessible (ping endpoint)

### Data not filling into form
1. Check browser Console for mapping errors
2. Verify database mappings exist in `api-mapping.php`
3. Check API response structure matches expected format

### CORS Error
1. The KPT API server must have CORS enabled
2. Contact API provider to enable CORS for your domain
3. If not possible, use PHP proxy (see Fallback Strategy)

## Reverting to Server-Side

If needed, the old PHP-based approach is still in `sql_akademik.php`:
- Function: `callKptSkpgApi($no_kp)`
- Processing: Lines 53-91 in sql_akademik.php
- To revert: Use the old AJAX call to `sql_akademik.php?frm=UNIV&pro=FETCH_UNIV_API`

## Files Not Modified

- `sql_akademik.php` - Kept for reference/fallback
- Other pages/modules - No changes needed
