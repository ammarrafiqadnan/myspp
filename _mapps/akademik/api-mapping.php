<?php
/**
 * API Mapping Helper
 * Provides institution and course mappings from local database to API codes
 */

session_start();
@include_once '../../connection/common.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
header('Content-Type: application/json');

// Only allow specific actions
if (!in_array($action, ['get_institution_map', 'get_course_map'])) {
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

if ($action == 'get_institution_map') {
    getInstitutionMapping();
} elseif ($action == 'get_course_map') {
    getCourseMapping();
}

/**
 * Get institution mapping (API code => Local code)
 */
function getInstitutionMapping() {
    global $conn, $schema1;
    
    try {
        $sql = "SELECT KOD_INTEGRASI, KOD, DISKRIPSI FROM $schema1.ref_institusi WHERE KOD_INTEGRASI IS NOT NULL";
        $rs = $conn->query($sql);
        
        $mapping = [];
        while (!$rs->EOF) {
            $apiCode = $rs->fields['KOD_INTEGRASI'];
            $mapping[$apiCode] = [
                'kod' => $rs->fields['KOD'],
                'nama' => $rs->fields['DISKRIPSI']
            ];
            $rs->movenext();
        }
        
        // Add caching headers
        header('Cache-Control: public, max-age=3600'); // Cache for 1 hour
        echo json_encode($mapping);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

/**
 * Get course mapping (API code => Local code)
 */
function getCourseMapping() {
    global $conn, $schema1;
    
    try {
        $sql = "SELECT A.kod_kpt, A.kod_myspp, B.DISKRIPSI 
                 FROM $schema1.ref_pengkhususan_kpt_padanan A
                 JOIN $schema1.ref_pengkhususan B ON A.kod_myspp = B.kod
                 WHERE A.kod_kpt IS NOT NULL";
        $rs = $conn->query($sql);
        
        $mapping = [];
        while (!$rs->EOF) {
            $apiCode = $rs->fields['kod_kpt'];
            $mapping[$apiCode] = [
                'kod' => $rs->fields['kod_myspp'],
                'nama' => $rs->fields['DISKRIPSI']
            ];
            $rs->movenext();
        }
        
        // Add caching headers
        header('Cache-Control: public, max-age=3600'); // Cache for 1 hour
        echo json_encode($mapping);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
