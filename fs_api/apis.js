// apis.js
async function loadApis() {
    // Load API base from config.txt
    const response = await fetch('../allconfig.txt');
    const text = await response.text();
    const line = text.split('\n').find(l => l.startsWith('API_URL='));
    const API_URL = line.split('=')[1].trim();
    const apibase = API_URL;

    console.log('API Base:', apibase);

    // Make apis global so your inline <script> can see it
    window.apis = [
        {
            name: "Get Fs Subscriber Profile",
            method: "GET",
            url: apibase + "/GetFs_Subscriber_Profile.php",
            desc: "Get Fs Subscriber Profile List."
        },
        {
            name: "Get MobionNumber",
            method: "GET",
            url: apibase + "/Get_MobionNumber.php",
            desc: "Get Mobion numbers List"
        },
        {
            name: "GPS Details",
            method: "POST",
            url: apibase + "/GPS_details.php",
            desc: "Insert GPS Details.",
            params: ["Mobile_Number", "Latitude", "Longitude", "Name", "Department"]
        },
        {
            name: "GPS Details Get",
            method: "POST",
            url: apibase + "/GPS_details_get.php",
            desc: "Get GPS Details.",
            params: ["regnumber"]
        },
        {
            name: "GPS Details Delete",
            method: "DELETE",
            url: apibase + "/GPS_details_delete.php",
            desc: "Delete GPS Details.",
            params: ["mobileNumber"]
        },
        {
            name: "GroupSetting View",
            method: "POST",
            url: apibase + "/GroupSetting_View.php",
            desc: "Get Group Setting View Details.",
            params: ["Number"]
        },
        {
            name: "Insert Call Details FS",
            method: "POST",
            url: apibase + "/Insert_Call_Details_FS.php",
            desc: "Insert Call Details FS Data",
            params: ["Subscriber_ID", "Call_Ref_ID", "Calling_Number", "Called_Number"
                , "Call_Type", "Call_Offer_Time", "Call_Connected_Time", "Call_disConnected_Time", "Call_Duration"
                , "Disconnected_Reason", "calltype", "Calling_No_Ip", "Called_No_Ip", "IMEI_NO", "IMSI_NO",
                "Network_Mode", "Calling_Number_City", "Called_Number_City", "Calling_Number_Country", "Called_Number_Country",
                "CAS_EXPORT_F", "BWinMB", "filename", "filesize", "IM_Message_TIME", "Reason", "groupid", "missedcallstatus",
                "callednumbernetworkmode", "conferenceid", "message", "Encryption", "Groupname"]
        },
        {
            name: "Mobion Login",
            method: "POST",
            url: apibase + "/Mobion_Login.php",
            desc: "Login with username & password.",
            params: ["UserName", "Password"]
        }

    ];
}

// Call loadApis first, then trigger loadAPIs() after data is ready
loadApis().then(() => {
    // Fire a custom event to signal readiness
    document.dispatchEvent(new Event('apisReady'));
});
