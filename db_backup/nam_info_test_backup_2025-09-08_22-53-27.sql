-- PostgreSQL Backup of database: nam_info_test
-- Generated on 2025-09-08 22:53:27

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;


-- ----------------------------
-- Table structure for "agent_cdr"
-- ----------------------------
DROP TABLE IF EXISTS "agent_cdr" CASCADE;
CREATE TABLE "agent_cdr" (
    "id" integer DEFAULT nextval('agent_cdr_id_seq'::regclass) NOT NULL,
    "callid" character varying(100),
    "fromnumber" character varying(50),
    "tonumber" character varying(50),
    "callstarttime" timestamp without time zone,
    "callendtime" timestamp without time zone,
    "callduration" character varying(50),
    "calltype" character varying(50),
    "calldirection" character varying(50),
    "callstatus" character varying(50),
    "recordingurl" character varying(255),
    "notes" text,
    "fromcountry" character varying(20),
    "tocountry" character varying(20),
    "filename" character varying(100),
    "call_types" character varying(100)
);

-- Dumping data for "agent_cdr"


-- ----------------------------
-- Table structure for "agent_contacts"
-- ----------------------------
DROP TABLE IF EXISTS "agent_contacts" CASCADE;
CREATE TABLE "agent_contacts" (
    "contactid" integer DEFAULT nextval('agent_contacts_contactid_seq'::regclass) NOT NULL,
    "firstname" character varying(50) NOT NULL,
    "lastname" character varying(50) NOT NULL,
    "email" character varying(100),
    "phonenumber" character varying(20),
    "address" character varying(255),
    "city" character varying(100),
    "state" character varying(100),
    "zipcode" character varying(20),
    "createddate" timestamp without time zone DEFAULT now()
);

-- Dumping data for "agent_contacts"


-- ----------------------------
-- Table structure for "agent_subscriber_profile"
-- ----------------------------
DROP TABLE IF EXISTS "agent_subscriber_profile" CASCADE;
CREATE TABLE "agent_subscriber_profile" (
    "id" bigint NOT NULL,
    "first_name" character varying(50),
    "last_name" character varying(50),
    "subscriber_id" character varying(50),
    "country_code" character varying(50),
    "mobile_no" character varying(50),
    "subscriber_password" character varying(50),
    "activated_date" timestamp without time zone,
    "expiry_date" timestamp without time zone,
    "res_no" character varying(50),
    "email" character varying(50),
    "company_name" character varying(50),
    "addr_1" character varying(50),
    "addr_2" character varying(50),
    "city" character varying(50),
    "state" character varying(50),
    "country" character varying(50),
    "designation" character varying(50),
    "area_code" character varying(50),
    "office_no" character varying(50),
    "extension_no" character varying(50),
    "email_notification_sent" character varying(50),
    "sms_notification_sent" character varying(50),
    "groupid" character varying(50),
    "smssent" boolean,
    "profile" character varying(50),
    "pbx" character varying(50),
    "status" integer,
    "timezone" character varying(100),
    "timedifference" double precision,
    "gmtsign" boolean,
    "daylightsaving" boolean,
    "dststartmonth" character varying(10),
    "dststartdate" character varying(10),
    "dstendmonth" character varying(10),
    "dstenddate" character varying(10),
    "imsino" character varying(150),
    "ipphoneno" character varying(50),
    "mobileuser" boolean,
    "landlineuser" boolean,
    "ipphoneuser" boolean,
    "mobionuser" boolean,
    "license_type" character varying(30),
    "days_of_validity" character varying(5),
    "action_date" timestamp without time zone
);

-- Dumping data for "agent_subscriber_profile"


-- ----------------------------
-- Table structure for "agent_useractivity"
-- ----------------------------
DROP TABLE IF EXISTS "agent_useractivity" CASCADE;
CREATE TABLE "agent_useractivity" (
    "id" integer DEFAULT nextval('agent_useractivity_id_seq'::regclass) NOT NULL,
    "subscriber_id" character varying(100) NOT NULL,
    "mobile_no" character varying(100) NOT NULL,
    "action" character varying(100) NOT NULL,
    "regstatus" text NOT NULL,
    "timestamp" timestamp without time zone DEFAULT now()
);

-- Dumping data for "agent_useractivity"


-- ----------------------------
-- Table structure for "call_details_fs"
-- ----------------------------
DROP TABLE IF EXISTS "call_details_fs" CASCADE;
CREATE TABLE "call_details_fs" (
    "id" integer DEFAULT nextval('call_details_fs_id_seq'::regclass) NOT NULL,
    "subscriber_id" character varying(50),
    "call_ref_id" character varying(50),
    "calling_number" character varying(50),
    "called_number" character varying(50),
    "call_type" character varying(20),
    "call_offer_time" timestamp without time zone,
    "call_connected_time" timestamp without time zone,
    "call_disconnected_time" timestamp without time zone,
    "call_duration" character varying(10),
    "calling_no_ip" character varying(50),
    "called_no_ip" character varying(50),
    "imei_no" character varying(50),
    "imsi_no" character varying(50),
    "disconnected_reason" character varying(100),
    "network_mode" integer,
    "calling_number_city" character varying(100),
    "called_number_city" character varying(100),
    "calling_number_country" character varying(100),
    "called_number_country" character varying(100),
    "cas_export_f" character varying(1),
    "bwinmb" character varying(20),
    "calltype" character varying(2),
    "filename" character varying(250),
    "filesize" character varying(10),
    "im_message_time" timestamp without time zone,
    "reason" character varying(50),
    "groupid" character varying(50),
    "missedcallstatus" integer,
    "callednumbernetworkmode" integer,
    "conferenceid" character varying(50),
    "message" text,
    "encryption" integer,
    "groupname" character varying(100)
);

-- Dumping data for "call_details_fs"


-- ----------------------------
-- Table structure for "chats"
-- ----------------------------
DROP TABLE IF EXISTS "chats" CASCADE;
CREATE TABLE "chats" (
    "chatid" integer DEFAULT nextval('chats_chatid_seq'::regclass) NOT NULL,
    "senderid" integer NOT NULL,
    "receiverid" integer NOT NULL,
    "message" text NOT NULL,
    "sentat" timestamp without time zone DEFAULT now(),
    "isread" boolean DEFAULT false,
    "attachment" bytea,
    "attachmentname" character varying(255),
    "attachmenttype" character varying(100),
    "ftp_url" text,
    "attachmentsize" character varying(100)
);

-- Dumping data for "chats"


-- ----------------------------
-- Table structure for "click2call_cdr"
-- ----------------------------
DROP TABLE IF EXISTS "click2call_cdr" CASCADE;
CREATE TABLE "click2call_cdr" (
    "id" integer DEFAULT nextval('click2call_cdr_id_seq'::regclass) NOT NULL,
    "callid" character varying(100),
    "fromnumber" character varying(50),
    "tonumber" character varying(50),
    "callstarttime" timestamp without time zone,
    "callendtime" timestamp without time zone,
    "callduration" character varying(50),
    "calltype" character varying(50),
    "callstatus" character varying(50),
    "recordingurl" character varying(255),
    "notes" text,
    "fromcountry" character varying(20),
    "tocountry" character varying(20),
    "filename" character varying(100)
);

-- Dumping data for "click2call_cdr"


-- ----------------------------
-- Table structure for "conference_layouts"
-- ----------------------------
DROP TABLE IF EXISTS "conference_layouts" CASCADE;
CREATE TABLE "conference_layouts" (
    "id" bigint NOT NULL,
    "layoutname" character varying(50),
    "action_date" timestamp without time zone
);

-- Dumping data for "conference_layouts"
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('1','1x1',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('2','1x2',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('3','2x1',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('4','2x1-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('5','3x1-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('6','5-grid-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('7','3x2-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('8','7-grid-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('9','4x2-zoom',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('10','1x1+2x1',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('11','2x2',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('12','3x3',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('13','4x4',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('14','5x5',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('15','6*6',NULL);
INSERT INTO "conference_layouts" ("id","layoutname","action_date") VALUES ('16','8*8',NULL);


-- ----------------------------
-- Table structure for "gps_details"
-- ----------------------------
DROP TABLE IF EXISTS "gps_details" CASCADE;
CREATE TABLE "gps_details" (
    "id" integer DEFAULT nextval('gps_details_id_seq'::regclass) NOT NULL,
    "mobile_number" character varying(20),
    "latitude" text,
    "longitude" text,
    "name" character varying(1000),
    "action_date" timestamp without time zone,
    "department" character varying(100)
);

-- Dumping data for "gps_details"


-- ----------------------------
-- Table structure for "group_setting"
-- ----------------------------
DROP TABLE IF EXISTS "group_setting" CASCADE;
CREATE TABLE "group_setting" (
    "group_number" character varying(50),
    "action_date" timestamp without time zone,
    "id" bigint NOT NULL,
    "group_name" character varying(100),
    "conference" character varying(100),
    "user_details" character varying(4000),
    "calltype" character varying(100),
    "moderate" character varying(1000)
);

-- Dumping data for "group_setting"


-- ----------------------------
-- Table structure for "ip_setting"
-- ----------------------------
DROP TABLE IF EXISTS "ip_setting" CASCADE;
CREATE TABLE "ip_setting" (
    "ip_name" character varying(50),
    "ip_address" character varying(50),
    "action_date" timestamp without time zone,
    "id" bigint NOT NULL
);

-- Dumping data for "ip_setting"
INSERT INTO "ip_setting" ("ip_name","ip_address","action_date","id") VALUES ('Internal_Rtp_IP & Sip_IP','10.185.13.38',NULL,'6');
INSERT INTO "ip_setting" ("ip_name","ip_address","action_date","id") VALUES ('External_Rtp_IP & Sip_IP','10.185.13.35.34',NULL,'5');


-- ----------------------------
-- Table structure for "layout_setting"
-- ----------------------------
DROP TABLE IF EXISTS "layout_setting" CASCADE;
CREATE TABLE "layout_setting" (
    "layoutnumber" character varying(50),
    "action_date" timestamp without time zone,
    "id" bigint NOT NULL
);

-- Dumping data for "layout_setting"
INSERT INTO "layout_setting" ("layoutnumber","action_date","id") VALUES ('8*8',NULL,'1');


-- ----------------------------
-- Table structure for "mobiweb_cdr"
-- ----------------------------
DROP TABLE IF EXISTS "mobiweb_cdr" CASCADE;
CREATE TABLE "mobiweb_cdr" (
    "id" integer DEFAULT nextval('mobiweb_cdr_id_seq'::regclass) NOT NULL,
    "callid" character varying(100),
    "fromnumber" character varying(50),
    "tonumber" character varying(50),
    "callstarttime" timestamp without time zone,
    "callendtime" timestamp without time zone,
    "callduration" character varying(50),
    "calltype" character varying(50),
    "calldirection" character varying(50),
    "callstatus" character varying(50),
    "recordingurl" character varying(255),
    "notes" text,
    "fromcountry" character varying(20),
    "tocountry" character varying(20),
    "filename" character varying(100),
    "call_types" character varying(100)
);

-- Dumping data for "mobiweb_cdr"


-- ----------------------------
-- Table structure for "pbx_cdr"
-- ----------------------------
DROP TABLE IF EXISTS "pbx_cdr" CASCADE;
CREATE TABLE "pbx_cdr" (
    "id" integer DEFAULT nextval('pbx_cdr_id_seq'::regclass) NOT NULL,
    "call_reference_no" character varying(50),
    "from_number" character varying(50),
    "to_number" character varying(50),
    "dialed_time" timestamp without time zone,
    "call_connected_time" timestamp without time zone,
    "call_disconnected_time" timestamp without time zone,
    "status" character varying(50)
);

-- Dumping data for "pbx_cdr"


-- ----------------------------
-- Table structure for "pbx_fs"
-- ----------------------------
DROP TABLE IF EXISTS "pbx_fs" CASCADE;
CREATE TABLE "pbx_fs" (
    "id" integer DEFAULT nextval('pbx_fs_id_seq'::regclass) NOT NULL,
    "name" character varying(100),
    "designation" character varying(100),
    "country" character varying(50),
    "extension_number" character varying(100)
);

-- Dumping data for "pbx_fs"


-- ----------------------------
-- Table structure for "port_setting"
-- ----------------------------
DROP TABLE IF EXISTS "port_setting" CASCADE;
CREATE TABLE "port_setting" (
    "id" integer DEFAULT nextval('port_setting_id_seq'::regclass) NOT NULL,
    "portnumber" character varying(50),
    "portname" character varying(50),
    "action_date" timestamp without time zone
);

-- Dumping data for "port_setting"
INSERT INTO "port_setting" ("id","portnumber","portname","action_date") VALUES ('4','508','Internal_Sip_Port',NULL);
INSERT INTO "port_setting" ("id","portnumber","portname","action_date") VALUES ('2','509','Internal_Tls_Port',NULL);
INSERT INTO "port_setting" ("id","portnumber","portname","action_date") VALUES ('5','600','WSS_Port',NULL);
INSERT INTO "port_setting" ("id","portnumber","portname","action_date") VALUES ('1','517','External_Tls_port',NULL);
INSERT INTO "port_setting" ("id","portnumber","portname","action_date") VALUES ('3','5115566','External_Sip_Port',NULL);


-- ----------------------------
-- Table structure for "registrationnumbers"
-- ----------------------------
DROP TABLE IF EXISTS "registrationnumbers" CASCADE;
CREATE TABLE "registrationnumbers" (
    "number" integer NOT NULL,
    "status" character varying(20) NOT NULL,
    "lastupdated" timestamp without time zone DEFAULT now()
);

-- Dumping data for "registrationnumbers"
INSERT INTO "registrationnumbers" ("number","status","lastupdated") VALUES ('1233','Unregistered','2025-12-07 00:00:00');


-- ----------------------------
-- Table structure for "subscriber"
-- ----------------------------
DROP TABLE IF EXISTS "subscriber" CASCADE;
CREATE TABLE "subscriber" (
    "subscriber_id" character varying(50) NOT NULL,
    "password" character varying(50) NOT NULL,
    "action_date" timestamp without time zone,
    "id" bigint NOT NULL
);

-- Dumping data for "subscriber"
INSERT INTO "subscriber" ("subscriber_id","password","action_date","id") VALUES ('Default','Naminfocom@123458',NULL,'1');


-- ----------------------------
-- Table structure for "subscriber_profile"
-- ----------------------------
DROP TABLE IF EXISTS "subscriber_profile" CASCADE;
CREATE TABLE "subscriber_profile" (
    "id" integer DEFAULT nextval('subscriber_profile_id_seq'::regclass) NOT NULL,
    "first_name" character varying(100),
    "last_name" character varying(100),
    "subscriber_id" character varying(50),
    "country_code" character varying(10),
    "mobile_no" character varying(50),
    "subscriber_password" character varying(255),
    "activated_date" timestamp without time zone,
    "expiry_date" timestamp without time zone,
    "res_no" character varying(50),
    "email" character varying(255),
    "company_name" character varying(255),
    "addr_1" character varying(255),
    "addr_2" character varying(255),
    "city" character varying(100),
    "state" character varying(100),
    "country" character varying(100),
    "designation" character varying(100),
    "area_code" character varying(50),
    "office_no" character varying(50),
    "extension_no" character varying(50),
    "email_notification_sent" character varying(10),
    "sms_notification_sent" character varying(10),
    "groupid" character varying(50),
    "smssent" integer,
    "profile" character varying(50),
    "pbx" character varying(50),
    "status" integer,
    "timezone" character varying(50),
    "timedifference" character varying(50),
    "gmtsign" character varying(10),
    "daylightsaving" integer,
    "dststartmonth" character varying(20),
    "dststartdate" character varying(20),
    "dstendmonth" character varying(20),
    "dstenddate" character varying(20),
    "imsino" character varying(100),
    "ipphoneno" character varying(100),
    "mobileuser" integer,
    "landlineuser" integer,
    "ipphoneuser" integer,
    "mobionuser" integer,
    "license_type" character varying(50),
    "days_of_validity" character varying(50),
    "action_date" timestamp without time zone,
    "mobion" character varying(50),
    "mobiweb" character varying(50)
);

-- Dumping data for "subscriber_profile"
INSERT INTO "subscriber_profile" ("id","first_name","last_name","subscriber_id","country_code","mobile_no","subscriber_password","activated_date","expiry_date","res_no","email","company_name","addr_1","addr_2","city","state","country","designation","area_code","office_no","extension_no","email_notification_sent","sms_notification_sent","groupid","smssent","profile","pbx","status","timezone","timedifference","gmtsign","daylightsaving","dststartmonth","dststartdate","dstendmonth","dstenddate","imsino","ipphoneno","mobileuser","landlineuser","ipphoneuser","mobionuser","license_type","days_of_validity","action_date","mobion","mobiweb") VALUES ('1',NULL,NULL,'admin',NULL,NULL,'admin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','Admin',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);


-- ----------------------------
-- Table structure for "t_registered"
-- ----------------------------
DROP TABLE IF EXISTS "t_registered" CASCADE;
CREATE TABLE "t_registered" (
    "skey" bigint,
    "namealias" character varying(300),
    "nameoriginal" character varying(300),
    "urlalias" character varying(300),
    "urloriginal" character varying(300),
    "acceptpattern" character varying(300),
    "requester" character varying(100),
    "expires" bigint,
    "priority" integer,
    "timeupdate" bigint,
    "expirestime" bigint,
    "mappedport" character varying(100),
    "awake" integer,
    "useragent" character varying(300),
    "param" character varying(300)
);

-- Dumping data for "t_registered"


-- ----------------------------
-- Table structure for "takeconference_list"
-- ----------------------------
DROP TABLE IF EXISTS "takeconference_list" CASCADE;
CREATE TABLE "takeconference_list" (
    "id" integer DEFAULT nextval('takeconference_list_id_seq'::regclass) NOT NULL,
    "from_number" character varying(15),
    "to_number" character varying(4000),
    "conferenceid" character varying(50),
    "action_date" timestamp without time zone
);

-- Dumping data for "takeconference_list"

