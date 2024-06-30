<?php
//INIALISASI CURL
function generateUUIDv4() {
    // Hasilkan 16 byte acak
    $data = random_bytes(16);

    // Set bit ke-4 dan ke-3 dari byte ke-7 dan ke-9 sesuai dengan spesifikasi UUID v4
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // Versi 4
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // Varian

    // Format byte menjadi string UUID
    return sprintf(
        '%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        ord($data[0]), ord($data[1]), ord($data[2]), ord($data[3]),
        ord($data[4]), ord($data[5]),
        ord($data[6]), ord($data[7]),
        ord($data[8]), ord($data[9]),
        ord($data[10]), ord($data[11]), ord($data[12]), ord($data[13]), ord($data[14]), ord($data[15])
    );
}
function auth($url,$data,$user_agent){
// Inisialisasi cURL
  $ch = curl_init();
  $headers = [
      'upgrade-insecure-requests: 1',
      'user-agent: '.$user_agent,
      'accept: application/json',
      'content-type: application/json',
      'content-length: '.strlen($data),
      'referer: https://www.jobstreet.co.id/job',
      'accept-encoding: gzip',
      'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
  ];
  // Set opsi cURL
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_ENCODING, "gzip");
  
  // Eksekusi permintaan
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  // Periksa kesalaha
  curl_close($ch);
  return [$httpCode,$response];
}
function job($url,$cookie,$user_agent){
$ch = curl_init($url);
$headers = [
    "Host: www.jobstreet.co.id",
    'sec-ch-ua: "Not/A)Brand";v="8", "Chromium";v="126", "Google Chrome";v="126"',
    "seek-request-country: ID",
    "sec-ch-ua-mobile: ?1",
    "user-agent: $user_agent",
    "accept: application/json",
    "seek-request-brand: jobstreet",
    "x-seek-site: Chalice",
    "x-seek-checksum: 12bd713d",
    'sec-ch-ua-platform: "Android"',
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://www.jobstreet.co.id/id/jobs-in-information-communication-technology?subclassification=6288%2C6290%2C6291%2C6289%2C6293%2C6303",
    "accept-encoding: gzip, deflate, br, zstd",
    "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
    "cookie: $cookie"
    
];
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

// Eksekusi cURL dan ambil responsnya
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
return [$httpCode,$response];
}
function graphql($url, $data,$auth,$cookie,$user_agent) {
    $ch = curl_init();
    $headers = array(
        'Content-Type: application/json',
        'Content-Length: '.strlen($data),
        'Authorization: '.$auth,
        'User-Agent: '.$user_agent,
        'Accept: application/features.seek.all+json, */*',
        'Origin: https://www.jobstreet.co.id',
        'Cookie: '.$cookie,
    );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    // Eksekusi curl dan dapatkan respons
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$httpCode,$response]; // Mengembalikan respons
}

//REQUIREMENT JOBSTREET
$client_id= 'qGPufUg5iBf1s57sfXl6gBdGF9JYInBI';
$session_id = '1da9922d-eb27-40a8-914b-c0d3c9adbb75';
$corelation_id = generateUUIDv4();
$resume = 'f0e608d4-60d6-4774-a15e-aadddf636dc9';
//REQUIREMENT URL
$url_graphql = 'https://www.jobstreet.co.id/graphql';
$url_job = "https://www.jobstreet.co.id/api/chalice-search/v4/search?siteKey=ID-Main&sourcesystem=houston&userqueryid=a911a6150f2dbc652aeafdb32c9935da-9353915&userid=$session_id&usersessionid=$session_id&eventCaptureSessionId=f1e0eea7-dc0f-4b89-b675-f6b602601481&page=1&seekSelectAllPages=true&classification=6281&subclassification=6288,6291,6293,6297,6303,6301,6300,6290,6289&sortmode=ListedDate&pageSize=30";
$url_auth = 'https://login.seek.com/oauth/token';
//REQUIREMENT FILE
$file_auth = 'auth.json';
//INISIALISASI HEADER
$cookie = 'JobseekerSessionId=1da9922d-eb27-40a8-914b-c0d3c9adbb75;JobseekerVisitorId=1da9922d-eb27-40a8-914b-c0d3c9adbb75;_gcl_au=1.1.1602647296.1719625791;_fbp=fb.2.1719625791312.846807153402909655;ajs_anonymous_id=6f0e82108a89a7b9b713597e4d7a8bc5;_legacy_auth0.qGPufUg5iBf1s57sfXl6gBdGF9JYInBI.is.authenticated=true;auth0.qGPufUg5iBf1s57sfXl6gBdGF9JYInBI.is.authenticated=true;_hjSessionUser_640499=eyJpZCI6IjBhZTExMTUxLTRjMDUtNWQ5NC05YjAzLTRlNTkwM2FlYzgzNiIsImNyZWF0ZWQiOjE3MTk2MjU3OTIxMjksImV4aXN0aW5nIjp0cnVlfQ==;last-known-sol-user-id=7e5cfcd95bd71abbc81eb867914929e53431e4eb8bdd54be9acea5e50f5711ce3346656b21e83378b2f18dae2323acff07973773d99712ba349ab29f8f822c7a86532142d29c92a220819dc489bbd97c590bfd1d76ce4280d8530ea49f6bc00d5d6d2f89182256d49600d74d811380b7c434c5a44d7f683ab283013639ef78c76353d123bae549efe84d2c04cd1bc80dee87989a88562fc3dc117d3b002873e3c8efc4c4b9e4c4;__cf_bm=bdBA5PxyciURa.LEaq5FfbJHJyc_OoZKXs9YCK_cRBU-1719669122-1.0.1.1-GRcMNgjD0AOTzr3l0wpFf91BZezG62qSkAtpDAI20unjiT2qnVqHTeLS_XQOhqUIaEsUtjY2FIyHSJDjPhcgzg;sol_id=c5891628-e959-47d4-9626-02b3cad10371;utag_main=v_id:019061af26f50011eb081b64868c0006f001c067005a9$_sn:6$_se:1%3Bexp-session$_ss:1%3Bexp-session$_st:1719670930146%3Bexp-session$ses_id:1719669130146%3Bexp-session$_pn:1%3Bexp-session$dc_visit:1$dc_event:91%3Bexp-session$dc_region:ap-east-1%3Bexp-session;da_cdt=visid_019061af26f50011eb081b64868c0006f001c067005a9-sesid_1719669130146;_dd_s=rum=0&expire=1719670026084';
$user_agent = 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36';
//INIALISASI AUTHORIZATION
function get_auth($file_auth,$url_auth,$client_id,$session_id,$user_agent) {
    if (!file_exists($file_auth)) {
        echo "[file] Authorization file not found\n";
        return null;
    }

    $auth_content = file_get_contents($file_auth);
    $auth_data = json_decode($auth_content, true);

    if (!is_array($auth_data)) {
        echo "[file_error]\n";
        echo "[message] auth_is_invalid\n";
        return null;
    }

    if (!isset($auth_data['access_token'])) {
        echo "[auth] Authorization not found\n";
        echo "[!] Please update your token\n";
        return null;
    }

    echo "[auth] Authorization has found\n";

    $auth = 'Bearer ' . $auth_data['access_token'];
    $refresh_token = $auth_data['refresh_token'];

    $auth_params = json_encode([
        "redirect_uri" => "https://www.jobstreet.co.id/oauth/callback/",
        "initial_scope" => "openid profile email offline_access",
        "JobseekerSessionId" => $session_id,
        "identity_sdk_version" => "6.54.0",
        "refresh_href" => "https://www.jobstreet.co.id/id/job/",
        "client_id" => $client_id,
        "grant_type" => "refresh_token",
        "refresh_token" => $refresh_token
    ]);

    $get_auth = auth($url_auth, $auth_params, $user_agent);
    $auth_code = $get_auth[0];
    $auth_content_decode = json_decode($get_auth[1], true);

    if ($auth_code == 200) {
        echo "[auth] Authorization has been updated\n";
        file_put_contents($file_auth, $get_auth[1]);
    } else {
        echo "[auth] Authorization not found\n";
        echo "[!] Please update your token\n";
        return null;
    }
    
    $time=time();
    return [$auth, $refresh_token, $auth_params,$time];
}
$auth_content=get_auth($file_auth,$url_auth,$client_id,$session_id,$user_agent);
$auth = $auth_content[0];
$refresh_token = $auth_content[1];
$auth_params = $auth_content[2];
function Task($url_job,$url_auth,$url_graphql,$auth,$client_id,$session_id,$resume,$corelation_id,$cookie,$user_agent){
$job_content = job($url_job,$cookie,$user_agent);
$job_content_code = $job_content[0];
$job_content_response = $job_content[1];
$job_content_decode = json_decode($job_content_response,true);
$job_star = $job_content_decode['data'];
$job_range = 3;
foreach($job_star as $job){
  if ($job_range < 1){
    break;
  }
  if(isset($job['id'])){
    $job_id = $job['id'];
    $graphql = ['{"operationName":"jobDetailsPersonalised","variables":{"id":"'.$job_id.'","languageCode":"id","locale":"id-ID","timezone":"Asia/Jakarta","zone":"asia-4"},"query":"query jobDetailsPersonalised($id: ID!, $tracking: JobDetailsTrackingInput, $locale: Locale!, $zone: Zone!, $languageCode: LanguageCodeIso!, $timezone: Timezone!) {\n  jobDetails(id: $id, tracking: $tracking) {\n    personalised {\n      isSaved\n      appliedDateTime {\n        longAbsoluteLabel(locale: $locale, timezone: $timezone)\n        __typename\n      }\n      topApplicantBadge {\n        label(locale: $locale)\n        description(locale: $locale, zone: $zone)\n        __typename\n      }\n      salaryMatch {\n        ... on JobProfileMissingSalaryPreference {\n          label(locale: $locale)\n          __typename\n        }\n        ... on JobProfileSalaryMatch {\n          label(locale: $locale)\n          salaryPreference(locale: $locale, languageCode: $languageCode) {\n            id\n            description\n            country {\n              countryCode\n              name\n              __typename\n            }\n            currencyCode\n            amount\n            salaryType\n            __typename\n          }\n          __typename\n        }\n        ... on JobProfileSalaryNoMatch {\n          label(locale: $locale)\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}','[{"operationName":"GetJobApplicationProcess","variables":{"jobId":"'.$job_id.'","isAuthenticated":true,"locale":"id-ID"},"query":"query GetJobApplicationProcess($jobId: ID!, $isAuthenticated: Boolean!, $locale: Locale) {\n  jobApplicationProcess(jobId: $jobId) {\n    ...LocationFragment\n    ...ClassificationFragment\n    ...DocumentsFragment\n    ...QuestionnaireFragment\n    job {\n      ...JobFragment\n      __typename\n    }\n    linkOut\n    extractedRoleTitles\n    __typename\n  }\n}\n\nfragment LocationFragment on JobApplicationProcess {\n  location {\n    id\n    name\n    __typename\n  }\n  state {\n    id\n    __typename\n  }\n  area {\n    id\n    name\n    __typename\n  }\n  __typename\n}\n\nfragment ClassificationFragment on JobApplicationProcess {\n  classification {\n    id\n    name\n    subClassification {\n      id\n      name\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment DocumentsFragment on JobApplicationProcess {\n  documents {\n    lastAppliedResumeIdPrefill @include(if: $isAuthenticated)\n    selectionCriteriaRequired\n    lastWrittenCoverLetter @include(if: $isAuthenticated) {\n      content\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment QuestionnaireFragment on JobApplicationProcess {\n  questionnaire {\n    questions @include(if: $isAuthenticated) {\n      id\n      text\n      __typename\n      ... on SingleChoiceQuestion {\n        lastAnswer {\n          id\n          text\n          uri\n          __typename\n        }\n        options {\n          id\n          text\n          uri\n          __typename\n        }\n        __typename\n      }\n      ... on MultipleChoiceQuestion {\n        lastAnswers {\n          id\n          text\n          uri\n          __typename\n        }\n        options {\n          id\n          text\n          uri\n          __typename\n        }\n        __typename\n      }\n      ... on PrivacyPolicyQuestion {\n        url\n        options {\n          id\n          text\n          uri\n          __typename\n        }\n        __typename\n      }\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment JobFragment on Job {\n  id\n  createdAt {\n    shortLabel\n    __typename\n  }\n  content\n  title\n  advertiser {\n    id\n    name(locale: $locale)\n    __typename\n  }\n  abstract\n  source\n  products {\n    branding {\n      id\n      logo {\n        url\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n  tracking {\n    hasRoleRequirements\n    __typename\n  }\n  __typename\n}"}]','[{"operationName":"GetJobDetails","variables":{"jobId":"'.$job_id.'","locale":"id-ID"},"query":"query GetJobDetails($jobId: ID!, $locale: Locale) {\n  jobDetails(id: $jobId) {\n    job {\n      ...JobFragment\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment JobFragment on Job {\n  id\n  createdAt {\n    shortLabel\n    __typename\n  }\n  content\n  title\n  advertiser {\n    id\n    name(locale: $locale)\n    __typename\n  }\n  abstract\n  source\n  products {\n    branding {\n      id\n      logo {\n        url\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n  tracking {\n    hasRoleRequirements\n    __typename\n  }\n  __typename\n}"},{"operationName":"GetApplicationQuestions","variables":{"jobId":"'.$job_id.'"},"query":"query GetApplicationQuestions($jobId: ID!) {\n  viewer {\n    _id\n    yearsOfExperience {\n      newToWorkforce\n      __typename\n    }\n    __typename\n  }\n  jobApplicationProcess(jobId: $jobId) {\n    questionnaire {\n      questions {\n        id\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}"},{"operationName":"DocumentsQuery","variables":{"jobId":"'.$job_id.'"},"query":"query DocumentsQuery($jobId: ID!) {\n  viewer {\n    _id\n    resumes {\n      ...resume\n      __typename\n    }\n    __typename\n  }\n  jobApplicationProcess(jobId: $jobId) {\n    documents {\n      lastAppliedResumeIdPrefill\n      selectionCriteriaRequired\n      lastWrittenCoverLetter {\n        content\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment resume on Resume {\n  id\n  createdDateUtc\n  isDefault\n  fileMetadata {\n    name\n    size\n    virusScanStatus\n    uri\n    __typename\n  }\n  origin {\n    type\n    __typename\n  }\n  __typename\n}"},{"operationName":"TrackJobApplicationStarted","variables":{"input":{"jobId":"'.$job_id.'","sessionId":"'.$session_id.'","applicationCorrelationId":"'.$corelation_id.'","isProfileApply":true}},"query":"mutation TrackJobApplicationStarted($input: TrackJobApplicationStartedInput!) {\n  trackJobApplicationStarted(input: $input) {\n    eventId\n    __typename\n  }\n}"}]','[{"operationName":"RequestResumeParsing","variables":{"input":{"id":"'.$resume.'","parsingContext":{"id":"'.$resume.'"},"zone":"asia-4"}},"query":"mutation RequestResumeParsing($input: RequestResumeParsingInput!) {\n  requestResumeParsing(input: $input) {\n    ref\n    __typename\n  }\n}"}]','[{"operationName":"GetRoles","variables":{},"query":"query GetRoles {\n  viewer {\n    _id\n    roles {\n      ...role\n      __typename\n    }\n    yearsOfExperience {\n      newToWorkforce\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment role on Role {\n  id\n  title {\n    text\n    ontologyId\n    __typename\n  }\n  company {\n    text\n    ontologyId\n    __typename\n  }\n  seniority {\n    text\n    ontologyId\n    __typename\n  }\n  from {\n    year\n    month\n    __typename\n  }\n  to {\n    year\n    month\n    __typename\n  }\n  achievements\n  function {\n    id\n    subFunction {\n      id\n      __typename\n    }\n    __typename\n  }\n  industry {\n    id\n    __typename\n  }\n  tracking {\n    events {\n      key\n      value\n      __typename\n    }\n    __typename\n  }\n  __typename\n}"},{"operationName":"GetQualifications","variables":{"zone":"asia-4","languageCode":"id"},"query":"query GetQualifications($zone: Zone!, $languageCode: LanguageCodeIso!) {\n  viewer {\n    ...RefreshedQualifications\n    __typename\n  }\n}\n\nfragment qualification on Qualification {\n  id\n  name {\n    text\n    ontologyId\n    __typename\n  }\n  institute {\n    text\n    ontologyId\n    __typename\n  }\n  completed\n  completionDate {\n    ... on Year {\n      year\n      __typename\n    }\n    ... on MonthYear {\n      month\n      year\n      __typename\n    }\n    __typename\n  }\n  formattedCompletion\n  highlights\n  status\n  verificationUrl\n  credential {\n    credentialInfo {\n      name\n      values\n      __typename\n    }\n    manageVerificationUrl\n    deleteVerificationUrl\n    __typename\n  }\n  __typename\n}\n\nfragment RefreshedQualifications on Candidate {\n  _id\n  qualifications(\n    includeVerified: true\n    status: confirmed\n    zone: $zone\n    languageCode: $languageCode\n  ) {\n    ...qualification\n    __typename\n  }\n  __typename\n}"},{"operationName":"GetLicences","variables":{"languageCode":"id","zone":"asia-4"},"query":"query GetLicences($languageCode: LanguageCodeIso, $zone: Zone) {\n  viewer {\n    _id\n    licences(languageCode: $languageCode, zone: $zone) {\n      ...licence\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment licence on Licence {\n  id\n  name {\n    text\n    ontologyId\n    __typename\n  }\n  issuingOrganisation\n  issueDate {\n    month\n    year\n    __typename\n  }\n  expiryDate {\n    month\n    year\n    __typename\n  }\n  noExpiryDate\n  description\n  status\n  formattedDate\n  verificationUrl\n  verificationMessage\n  credentialType\n  credential {\n    verification {\n      result\n      __typename\n    }\n    credentialInfo {\n      name\n      values\n      __typename\n    }\n    manageVerificationUrl\n    deleteVerificationUrl\n    __typename\n  }\n  __typename\n}"},{"operationName":"GetSkills","variables":{},"query":"query GetSkills {\n  viewer {\n    _id\n    skills {\n      keyword {\n        text\n        ontologyId\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}"},{"operationName":"UnconfirmedDataQuery","variables":{"contextId":"'.$resume.'","languageCode":"id"},"query":"query UnconfirmedDataQuery($contextId: String!, $languageCode: LanguageCodeIso!) {\n  viewer {\n    _id\n    unconfirmedDataForContext(\n      contextId: $contextId\n      contextType: Application\n      languageCode: $languageCode\n    ) {\n      ... on UnconfirmedDataPending {\n        completed\n        __typename\n      }\n      ... on UnconfirmedDataCompleted {\n        completed\n        roles {\n          ...unconfirmedRole\n          __typename\n        }\n        qualifications {\n          ...unconfirmedQualification\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment role on Role {\n  id\n  title {\n    text\n    ontologyId\n    __typename\n  }\n  company {\n    text\n    ontologyId\n    __typename\n  }\n  seniority {\n    text\n    ontologyId\n    __typename\n  }\n  from {\n    year\n    month\n    __typename\n  }\n  to {\n    year\n    month\n    __typename\n  }\n  achievements\n  function {\n    id\n    subFunction {\n      id\n      __typename\n    }\n    __typename\n  }\n  industry {\n    id\n    __typename\n  }\n  tracking {\n    events {\n      key\n      value\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment qualification on Qualification {\n  id\n  name {\n    text\n    ontologyId\n    __typename\n  }\n  institute {\n    text\n    ontologyId\n    __typename\n  }\n  completed\n  completionDate {\n    ... on Year {\n      year\n      __typename\n    }\n    ... on MonthYear {\n      month\n      year\n      __typename\n    }\n    __typename\n  }\n  formattedCompletion\n  highlights\n  status\n  verificationUrl\n  credential {\n    credentialInfo {\n      name\n      values\n      __typename\n    }\n    manageVerificationUrl\n    deleteVerificationUrl\n    __typename\n  }\n  __typename\n}\n\nfragment unconfirmedRole on Role {\n  ...role\n  __typename\n}\n\nfragment unconfirmedQualification on Qualification {\n  ...qualification\n  tracking {\n    events {\n      key\n      value\n      __typename\n    }\n    __typename\n  }\n  __typename\n}"}]'];
    $apply_data= '[{
              "operationName": "ApplySubmitApplication",
              "variables": {
                  "input": {
                      "jobId": "'.$job_id.'",
                      "correlationId": "'.$corelation_id.'",
                      "zone": "asia-4",
                      "profilePrivacyLevel": "Standard",
                      "resume": {
                          "id": "'.$resume.'",
                          "uri": "/v2/blobstore/resumes/'.$resume.'/",
                          "idFromResumeResource": -1
                      },
                      "mostRecentRole": {
                          "company": "Sekretariat DPRD Kabupaten Lebak ",
                          "title": "Office /IT Support",
                          "started": {
                              "year": 2023,
                              "month": 7
                          },
                          "finished": {
                              "year": 2023,
                              "month": 12
                          }
                      },
                      "questionnaireAnswers": []
                  },
                  "locale": "id-ID"
              },
              "query": "mutation ApplySubmitApplication($input: SubmitApplicationInput!, $locale: Locale) {\n  submitApplication(input: $input) {\n    ... on SubmitApplicationSuccess {\n      applicationId\n      __typename\n    }\n    ... on SubmitApplicationFailure {\n      errors {\n        message(locale: $locale)\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}"
          }]';
    $apply_data_decode= json_decode($apply_data,true);
    $job_location= $job['location'];
    $job_company= $job['companyName'];
    $job_release= $job['listingDate'];
    echo("\n[job|$job_content_code]\n");
    echo("  => [id] $job_id\n");
    echo("  => [companyName] $job_company\n");
    echo("  => [location] $job_location\n");
    echo("  => [releaseDate] $job_release\n");
    $i = 0;
foreach ($graphql as $query) {
    $get_graphql = graphql($url_graphql, $query, $auth, $cookie, $user_agent);
    $graphql_code = $get_graphql[0];
    $graphql_response = $get_graphql[1];
    $graphql_decode = json_decode($graphql_response, $graphql_code);
    
    if (isset($graphql_decode['errors'][0]['extensions']['code'])) {
        echo "[auth] UNAUTHENTICATED\n";
        echo "[!] Please update your token\n";
        die();
    } else if ($i == 0) {
        echo("\n[graphql]\n");
    }
    
    echo "[" . strval($i + 1) . "] => HTTP Response Code : " . $graphql_code . "\n";
    
    // GRAPHQL TITLE
    if ($i == 0) {
        $graphql_session = 'jobDetailsPersonalised';
    } else if ($i == 1) {
        $graphql_session = 'GetJobApplicationProcess';
    } else if ($i == 2) {
        $graphql_session = 'GetJobDetails';
    } else if ($i == 3) {
        $graphql_session = 'RequestResumeParsing';
    } else if ($i == 4) {
        $graphql_session = 'GetRoles';
    }
    
    if ($graphql_session == 'jobDetailsPersonalised') {
        $appliedDateTime =$graphql_decode['data']['jobDetails']['personalised']['appliedDateTime'];
        if ($appliedDateTime == null) {
            $i++;
            continue;
        } else if ($appliedDateTime != null) {
            $appliedDateTime = $appliedDateTime['longAbsoluteLabel'];
            echo "    => [appliedDateTime] => ".$appliedDateTime."\n";
            break;
        } else {
            echo "    => [graphql_error]\n";
            echo "    => [message] appliedDateTime not found\n";
        }
    }
    
    if ($graphql_session == 'GetJobApplicationProcess') {
        $answer = [];
        $linkOut = $graphql_decode[0]['data']['jobApplicationProcess']['linkOut'];
        if ($linkOut == true) {
            echo("    => [link_out]\n");
            break;
        } else {
            $questions = $graphql_decode[0]['data']['jobApplicationProcess']['questionnaire']['questions'];
            foreach ($questions as $question) {
                $id_question = $question['id'];
                $type_question = $question['__typename'];
                $text_question = $question['text'];
                $options_answer = $question['options'];
                $key1 = ['lama', 'experience', 'Information', 'year', 'pengalaman', 'tahun', 'Pengalaman'];
                $key2 = ['language', 'Bahasa', 'bahasa'];
                $sum_of_key1 = 0;
                $sum_of_key2 = 0;
                $last_options = count($options_answer) - 1;
                
                foreach ($key1 as $key) {
                    $sum_of_key1 += substr_count($text_question, $key);
                }
                
                foreach ($key2 as $key) {
                    $sum_of_key2 += substr_count($text_question, $key);
                }
                
                if (isset($question['lastAnswer'])) {
                    $answer[] = $question['lastAnswer'];
                } else if ($sum_of_key1 >= 1 and $type_question == 'SingleChoiceQuestion') {
                    $answer[] = $options_answer[1];
                } else if ($sum_of_key2 >= 1 and $type_question == 'MultipleChoiceQuestion') {
                    $answer[] = $options_answer[1];
                    $answer[] = end($options_answer);
                } else if ($sum_of_key1 == 0 and $type_question == 'SingleChoiceQuestion') {
                    $answer[] = $options_answer[0];
                } else {
                    $answer[] = $options_answer[0];
                }
                
                $input__answer = [
                    "questionId" => $id_question,
                    "answers" => $answer
                ];
                
                unset($input__answer['answers'][0]['__typename']);
                $apply_data_decode[0]['variables']['input']['questionnaireAnswers'][] = $input__answer;
                $apply_params = json_encode($apply_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }
    }
    $i++;
    // END GRAPHQL
}
//END JIB
  } else{
    echo "[job_error] something went wrong\n";
    die();
    }
    
    $job_range --;
  }
  for($i = 60; $i > 0; $i--){
    $mod = $i % 3;
    if($mod == 0) {
        echo "•\r";
    } elseif($mod == 2) {
        echo "••\r";
    } else {
        echo "•••\r";
    }
    sleep(1);
    echo "\r             \r";
}
  $time = time();
  return $time;
}

//TIME HANDLING
$last_auth_time= end($auth_content);
$curTime=Task($url_job,$url_auth,$url_graphql,$auth,$client_id,$session_id,$resume,$corelation_id,$cookie,$user_agent);

while(true){
  if(($curTime - $last_auth_time) >= 50 * 60 ){
    $auth_content=get_auth($file_auth,$url_auth,$client_id,$session_id,$user_agent);
    $auth = $auth_content[0];
    $refresh_token = $auth_content[1];
    $auth_params = $auth_content[2];
    $last_auth_time= end($auth_content);
  }
  $curTime = Task($url_job,$url_auth,$url_graphql,$auth,$client_id,$session_id,$resume,$corelation_id,$cookie,$user_agent);
}