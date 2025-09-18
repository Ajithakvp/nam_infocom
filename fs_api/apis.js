// apis.js
const apibase = "http://localhost/nam_infocom/fs_api";
const apis = [
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
