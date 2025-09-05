--
-- PostgreSQL database dump
--

\restrict aTIOkdnVk0fHgIRKdf1JsFClJJUNGgSmiTsOGp5hs8Bem9WYIvGHDMlIOr9Tn3v

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

-- Started on 2025-08-30 16:08:17

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 16401)
-- Name: agent_cdr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent_cdr (
    callid character varying(100),
    fromnumber character varying(50),
    tonumber character varying(50),
    callstarttime timestamp without time zone,
    callendtime timestamp without time zone,
    callduration character varying(50),
    calltype character varying(50),
    calldirection character varying(50),
    callstatus character varying(50),
    recordingurl character varying(255),
    notes text,
    fromcountry character varying(20),
    tocountry character varying(20),
    filename character varying(100),
    call_types character varying(100)
);


ALTER TABLE public.agent_cdr OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16407)
-- Name: agent_contacts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent_contacts (
    contactid integer NOT NULL,
    firstname character varying(50) NOT NULL,
    lastname character varying(50) NOT NULL,
    email character varying(100),
    phonenumber character varying(20),
    address character varying(255),
    city character varying(100),
    state character varying(100),
    zipcode character varying(20),
    createddate timestamp without time zone DEFAULT now()
);


ALTER TABLE public.agent_contacts OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16406)
-- Name: agent_contacts_contactid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.agent_contacts_contactid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.agent_contacts_contactid_seq OWNER TO postgres;

--
-- TOC entry 5061 (class 0 OID 0)
-- Dependencies: 218
-- Name: agent_contacts_contactid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.agent_contacts_contactid_seq OWNED BY public.agent_contacts.contactid;


--
-- TOC entry 221 (class 1259 OID 16417)
-- Name: agent_subscriber_profile; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent_subscriber_profile (
    first_name character varying(50),
    last_name character varying(50),
    subscriber_id character varying(50),
    country_code character varying(50),
    mobile_no character varying(50),
    subscriber_password character varying(50),
    activated_date timestamp without time zone,
    expiry_date timestamp without time zone,
    res_no character varying(50),
    email character varying(50),
    company_name character varying(50),
    addr_1 character varying(50),
    addr_2 character varying(50),
    city character varying(50),
    state character varying(50),
    country character varying(50),
    designation character varying(50),
    area_code character varying(50),
    office_no character varying(50),
    extension_no character varying(50),
    email_notification_sent character varying(50),
    sms_notification_sent character varying(50),
    groupid character varying(50),
    smssent boolean,
    profile character varying(50),
    pbx character varying(50),
    status integer,
    timezone character varying(100),
    timedifference double precision,
    gmtsign boolean,
    daylightsaving boolean,
    dststartmonth character varying(10),
    dststartdate character varying(10),
    dstendmonth character varying(10),
    dstenddate character varying(10),
    imsino character varying(150),
    ipphoneno character varying(50),
    mobileuser boolean,
    landlineuser boolean,
    ipphoneuser boolean,
    mobionuser boolean,
    license_type character varying(30),
    days_of_validity character varying(5),
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.agent_subscriber_profile OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16416)
-- Name: agent_subscriber_profile_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.agent_subscriber_profile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.agent_subscriber_profile_id_seq OWNER TO postgres;

--
-- TOC entry 5062 (class 0 OID 0)
-- Dependencies: 220
-- Name: agent_subscriber_profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.agent_subscriber_profile_id_seq OWNED BY public.agent_subscriber_profile.id;


--
-- TOC entry 223 (class 1259 OID 16426)
-- Name: agent_useractivity; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent_useractivity (
    id integer NOT NULL,
    subscriber_id character varying(100) NOT NULL,
    mobile_no character varying(100) NOT NULL,
    action character varying(100) NOT NULL,
    regstatus text NOT NULL,
    "timestamp" timestamp without time zone DEFAULT now()
);


ALTER TABLE public.agent_useractivity OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16425)
-- Name: agent_useractivity_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.agent_useractivity_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.agent_useractivity_id_seq OWNER TO postgres;

--
-- TOC entry 5063 (class 0 OID 0)
-- Dependencies: 222
-- Name: agent_useractivity_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.agent_useractivity_id_seq OWNED BY public.agent_useractivity.id;


--
-- TOC entry 224 (class 1259 OID 16435)
-- Name: call_details_fs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.call_details_fs (
    subscriber_id character varying(50),
    call_ref_id character varying(50),
    calling_number character varying(50),
    called_number character varying(50),
    call_type character varying(20),
    call_offer_time timestamp without time zone,
    call_connected_time timestamp without time zone,
    call_disconnected_time timestamp without time zone,
    call_duration character varying(10),
    calling_no_ip character varying(50),
    called_no_ip character varying(50),
    imei_no character varying(50),
    imsi_no character varying(50),
    disconnected_reason character varying(100),
    network_mode integer,
    calling_number_city character varying(100),
    called_number_city character varying(100),
    calling_number_country character varying(100),
    called_number_country character varying(100),
    cas_export_f character varying(1),
    bwinmb character varying(20),
    calltype character varying(2),
    filename character varying(250),
    filesize character varying(10),
    im_message_time timestamp without time zone,
    reason character varying(50),
    groupid character varying(50),
    missedcallstatus integer,
    callednumbernetworkmode integer,
    conferenceid character varying(50),
    message text,
    encryption integer,
    groupname character varying(100)
);


ALTER TABLE public.call_details_fs OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16441)
-- Name: chats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chats (
    chatid integer NOT NULL,
    senderid integer NOT NULL,
    receiverid integer NOT NULL,
    message text NOT NULL,
    sentat timestamp without time zone DEFAULT now(),
    isread boolean DEFAULT false,
    attachment bytea,
    attachmentname character varying(255),
    attachmenttype character varying(100),
    ftp_url text,
    attachmentsize character varying(100)
);


ALTER TABLE public.chats OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16440)
-- Name: chats_chatid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chats_chatid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.chats_chatid_seq OWNER TO postgres;

--
-- TOC entry 5064 (class 0 OID 0)
-- Dependencies: 225
-- Name: chats_chatid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.chats_chatid_seq OWNED BY public.chats.chatid;


--
-- TOC entry 227 (class 1259 OID 16451)
-- Name: click2call_cdr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.click2call_cdr (
    callid character varying(100),
    fromnumber character varying(50),
    tonumber character varying(50),
    callstarttime timestamp without time zone,
    callendtime timestamp without time zone,
    callduration character varying(50),
    calltype character varying(50),
    callstatus character varying(50),
    recordingurl character varying(255),
    notes text,
    fromcountry character varying(20),
    tocountry character varying(20),
    filename character varying(100)
);


ALTER TABLE public.click2call_cdr OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 16457)
-- Name: conference_layouts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.conference_layouts (
    layoutname character varying(50),
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.conference_layouts OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16456)
-- Name: conference_layouts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.conference_layouts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.conference_layouts_id_seq OWNER TO postgres;

--
-- TOC entry 5065 (class 0 OID 0)
-- Dependencies: 228
-- Name: conference_layouts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.conference_layouts_id_seq OWNED BY public.conference_layouts.id;


--
-- TOC entry 230 (class 1259 OID 16463)
-- Name: gps_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gps_details (
    mobile_number character varying(20),
    latitude text,
    longitude text,
    name character varying(1000),
    action_date timestamp without time zone,
    department character varying(100)
);


ALTER TABLE public.gps_details OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16469)
-- Name: group_setting; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.group_setting (
    group_number character varying(50),
    action_date timestamp without time zone,
    id bigint NOT NULL,
    group_name character varying(100),
    conference character varying(100),
    user_details character varying(4000),
    calltype character varying(100),
    moderate character varying(1000)
);


ALTER TABLE public.group_setting OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16468)
-- Name: group_setting_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.group_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.group_setting_id_seq OWNER TO postgres;

--
-- TOC entry 5066 (class 0 OID 0)
-- Dependencies: 231
-- Name: group_setting_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.group_setting_id_seq OWNED BY public.group_setting.id;


--
-- TOC entry 250 (class 1259 OID 16562)
-- Name: group_setting_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.group_setting ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.group_setting_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 234 (class 1259 OID 16478)
-- Name: ip_setting; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ip_setting (
    ip_name character varying(50),
    ip_address character varying(50),
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.ip_setting OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 16477)
-- Name: ip_setting_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ip_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ip_setting_id_seq OWNER TO postgres;

--
-- TOC entry 5067 (class 0 OID 0)
-- Dependencies: 233
-- Name: ip_setting_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ip_setting_id_seq OWNED BY public.ip_setting.id;


--
-- TOC entry 236 (class 1259 OID 16485)
-- Name: layout_setting; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.layout_setting (
    layoutnumber character varying(50),
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.layout_setting OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 16484)
-- Name: layout_setting_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.layout_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.layout_setting_id_seq OWNER TO postgres;

--
-- TOC entry 5068 (class 0 OID 0)
-- Dependencies: 235
-- Name: layout_setting_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.layout_setting_id_seq OWNED BY public.layout_setting.id;


--
-- TOC entry 237 (class 1259 OID 16491)
-- Name: mobiweb_cdr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mobiweb_cdr (
    callid character varying(100),
    fromnumber character varying(50),
    tonumber character varying(50),
    callstarttime timestamp without time zone,
    callendtime timestamp without time zone,
    callduration character varying(50),
    calltype character varying(50),
    calldirection character varying(50),
    callstatus character varying(50),
    recordingurl character varying(255),
    notes text,
    fromcountry character varying(20),
    tocountry character varying(20),
    filename character varying(100),
    call_types character varying(100)
);


ALTER TABLE public.mobiweb_cdr OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 16496)
-- Name: pbx_cdr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pbx_cdr (
    call_reference_no character varying(50),
    from_number character varying(50),
    to_number character varying(50),
    dialed_time timestamp without time zone,
    call_connected_time timestamp without time zone,
    call_disconnected_time timestamp without time zone,
    status character varying(50)
);


ALTER TABLE public.pbx_cdr OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 16500)
-- Name: pbx_fs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pbx_fs (
    id integer NOT NULL,
    name character varying(100),
    designation character varying(100),
    country character varying(50),
    extension_number character varying(100)
);


ALTER TABLE public.pbx_fs OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 16499)
-- Name: pbx_fs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pbx_fs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pbx_fs_id_seq OWNER TO postgres;

--
-- TOC entry 5069 (class 0 OID 0)
-- Dependencies: 239
-- Name: pbx_fs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pbx_fs_id_seq OWNED BY public.pbx_fs.id;


--
-- TOC entry 242 (class 1259 OID 16507)
-- Name: port_setting; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.port_setting (
    portnumber character varying(50),
    portname character varying(50),
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.port_setting OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 16506)
-- Name: port_setting_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.port_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.port_setting_id_seq OWNER TO postgres;

--
-- TOC entry 5070 (class 0 OID 0)
-- Dependencies: 241
-- Name: port_setting_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.port_setting_id_seq OWNED BY public.port_setting.id;


--
-- TOC entry 243 (class 1259 OID 16513)
-- Name: registrationnumbers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registrationnumbers (
    number integer NOT NULL,
    status character varying(20) NOT NULL,
    lastupdated timestamp without time zone DEFAULT now(),
    CONSTRAINT registrationnumbers_status_check CHECK (((status)::text = ANY ((ARRAY['Registered'::character varying, 'Unregistered'::character varying])::text[])))
);


ALTER TABLE public.registrationnumbers OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 16521)
-- Name: subscriber; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subscriber (
    subscriber_id character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    action_date timestamp without time zone,
    id bigint NOT NULL
);


ALTER TABLE public.subscriber OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 16520)
-- Name: subscriber_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subscriber_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subscriber_id_seq OWNER TO postgres;

--
-- TOC entry 5071 (class 0 OID 0)
-- Dependencies: 244
-- Name: subscriber_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subscriber_id_seq OWNED BY public.subscriber.id;


--
-- TOC entry 249 (class 1259 OID 16548)
-- Name: subscriber_profile; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subscriber_profile (
    id integer NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    subscriber_id character varying(50),
    country_code character varying(10),
    mobile_no character varying(50),
    subscriber_password character varying(255),
    activated_date timestamp without time zone,
    expiry_date timestamp without time zone,
    res_no character varying(50),
    email character varying(255),
    company_name character varying(255),
    addr_1 character varying(255),
    addr_2 character varying(255),
    city character varying(100),
    state character varying(100),
    country character varying(100),
    designation character varying(100),
    area_code character varying(50),
    office_no character varying(50),
    extension_no character varying(50),
    email_notification_sent character varying(10),
    sms_notification_sent character varying(10),
    groupid character varying(50),
    smssent integer,
    profile character varying(50),
    pbx character varying(50),
    status integer,
    timezone character varying(50),
    timedifference character varying(50),
    gmtsign character varying(10),
    daylightsaving integer,
    dststartmonth character varying(20),
    dststartdate character varying(20),
    dstendmonth character varying(20),
    dstenddate character varying(20),
    imsino character varying(100),
    ipphoneno character varying(100),
    mobileuser integer,
    landlineuser integer,
    ipphoneuser integer,
    mobionuser integer,
    license_type character varying(50),
    days_of_validity character varying(50),
    action_date timestamp without time zone,
    mobion character varying(50),
    mobiweb character varying(50)
);


ALTER TABLE public.subscriber_profile OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 16547)
-- Name: subscriber_profile_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subscriber_profile_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subscriber_profile_id_seq OWNER TO postgres;

--
-- TOC entry 5072 (class 0 OID 0)
-- Dependencies: 248
-- Name: subscriber_profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subscriber_profile_id_seq OWNED BY public.subscriber_profile.id;


--
-- TOC entry 246 (class 1259 OID 16536)
-- Name: t_registered; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.t_registered (
    skey bigint,
    namealias character varying(300),
    nameoriginal character varying(300),
    urlalias character varying(300),
    urloriginal character varying(300),
    acceptpattern character varying(300),
    requester character varying(100),
    expires bigint,
    priority integer,
    timeupdate bigint,
    expirestime bigint,
    mappedport character varying(100),
    awake integer,
    useragent character varying(300),
    param character varying(300)
);


ALTER TABLE public.t_registered OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 16541)
-- Name: takeconference_list; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.takeconference_list (
    from_number character varying(15),
    to_number character varying(4000),
    conferenceid character varying(50),
    action_date timestamp without time zone
);


ALTER TABLE public.takeconference_list OWNER TO postgres;

--
-- TOC entry 4834 (class 2604 OID 16410)
-- Name: agent_contacts contactid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_contacts ALTER COLUMN contactid SET DEFAULT nextval('public.agent_contacts_contactid_seq'::regclass);


--
-- TOC entry 4836 (class 2604 OID 16420)
-- Name: agent_subscriber_profile id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_subscriber_profile ALTER COLUMN id SET DEFAULT nextval('public.agent_subscriber_profile_id_seq'::regclass);


--
-- TOC entry 4837 (class 2604 OID 16429)
-- Name: agent_useractivity id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_useractivity ALTER COLUMN id SET DEFAULT nextval('public.agent_useractivity_id_seq'::regclass);


--
-- TOC entry 4839 (class 2604 OID 16444)
-- Name: chats chatid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chats ALTER COLUMN chatid SET DEFAULT nextval('public.chats_chatid_seq'::regclass);


--
-- TOC entry 4842 (class 2604 OID 16460)
-- Name: conference_layouts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conference_layouts ALTER COLUMN id SET DEFAULT nextval('public.conference_layouts_id_seq'::regclass);


--
-- TOC entry 4843 (class 2604 OID 16481)
-- Name: ip_setting id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ip_setting ALTER COLUMN id SET DEFAULT nextval('public.ip_setting_id_seq'::regclass);


--
-- TOC entry 4844 (class 2604 OID 16488)
-- Name: layout_setting id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.layout_setting ALTER COLUMN id SET DEFAULT nextval('public.layout_setting_id_seq'::regclass);


--
-- TOC entry 4845 (class 2604 OID 16503)
-- Name: pbx_fs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pbx_fs ALTER COLUMN id SET DEFAULT nextval('public.pbx_fs_id_seq'::regclass);


--
-- TOC entry 4846 (class 2604 OID 16510)
-- Name: port_setting id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.port_setting ALTER COLUMN id SET DEFAULT nextval('public.port_setting_id_seq'::regclass);


--
-- TOC entry 4848 (class 2604 OID 16524)
-- Name: subscriber id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subscriber ALTER COLUMN id SET DEFAULT nextval('public.subscriber_id_seq'::regclass);


--
-- TOC entry 4849 (class 2604 OID 16551)
-- Name: subscriber_profile id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subscriber_profile ALTER COLUMN id SET DEFAULT nextval('public.subscriber_profile_id_seq'::regclass);



--
-- TOC entry 5073 (class 0 OID 0)
-- Dependencies: 218
-- Name: agent_contacts_contactid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.agent_contacts_contactid_seq', 1, false);


--
-- TOC entry 5074 (class 0 OID 0)
-- Dependencies: 220
-- Name: agent_subscriber_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.agent_subscriber_profile_id_seq', 1, false);


--
-- TOC entry 5075 (class 0 OID 0)
-- Dependencies: 222
-- Name: agent_useractivity_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.agent_useractivity_id_seq', 1, false);


--
-- TOC entry 5076 (class 0 OID 0)
-- Dependencies: 225
-- Name: chats_chatid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chats_chatid_seq', 1, false);


--
-- TOC entry 5077 (class 0 OID 0)
-- Dependencies: 228
-- Name: conference_layouts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.conference_layouts_id_seq', 1, false);


--
-- TOC entry 5078 (class 0 OID 0)
-- Dependencies: 231
-- Name: group_setting_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.group_setting_id_seq', 2, true);


--
-- TOC entry 5079 (class 0 OID 0)
-- Dependencies: 250
-- Name: group_setting_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.group_setting_id_seq1', 12, true);


--
-- TOC entry 5080 (class 0 OID 0)
-- Dependencies: 233
-- Name: ip_setting_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ip_setting_id_seq', 1, false);


--
-- TOC entry 5081 (class 0 OID 0)
-- Dependencies: 235
-- Name: layout_setting_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.layout_setting_id_seq', 1, false);


--
-- TOC entry 5082 (class 0 OID 0)
-- Dependencies: 239
-- Name: pbx_fs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pbx_fs_id_seq', 1, false);


--
-- TOC entry 5083 (class 0 OID 0)
-- Dependencies: 241
-- Name: port_setting_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.port_setting_id_seq', 1, false);


--
-- TOC entry 5084 (class 0 OID 0)
-- Dependencies: 244
-- Name: subscriber_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subscriber_id_seq', 1, false);


--
-- TOC entry 5085 (class 0 OID 0)
-- Dependencies: 248
-- Name: subscriber_profile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subscriber_profile_id_seq', 14, true);


--
-- TOC entry 4852 (class 2606 OID 16415)
-- Name: agent_contacts agent_contacts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_contacts
    ADD CONSTRAINT agent_contacts_pkey PRIMARY KEY (contactid);


--
-- TOC entry 4854 (class 2606 OID 16424)
-- Name: agent_subscriber_profile agent_subscriber_profile_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_subscriber_profile
    ADD CONSTRAINT agent_subscriber_profile_pkey PRIMARY KEY (id);


--
-- TOC entry 4856 (class 2606 OID 16434)
-- Name: agent_useractivity agent_useractivity_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_useractivity
    ADD CONSTRAINT agent_useractivity_pkey PRIMARY KEY (id);


--
-- TOC entry 4858 (class 2606 OID 16450)
-- Name: chats chats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chats
    ADD CONSTRAINT chats_pkey PRIMARY KEY (chatid);


--
-- TOC entry 4860 (class 2606 OID 16462)
-- Name: conference_layouts conference_layouts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conference_layouts
    ADD CONSTRAINT conference_layouts_pkey PRIMARY KEY (id);


--
-- TOC entry 4862 (class 2606 OID 16476)
-- Name: group_setting group_setting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.group_setting
    ADD CONSTRAINT group_setting_pkey PRIMARY KEY (id);


--
-- TOC entry 4864 (class 2606 OID 16483)
-- Name: ip_setting ip_setting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ip_setting
    ADD CONSTRAINT ip_setting_pkey PRIMARY KEY (id);


--
-- TOC entry 4866 (class 2606 OID 16490)
-- Name: layout_setting layout_setting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.layout_setting
    ADD CONSTRAINT layout_setting_pkey PRIMARY KEY (id);


--
-- TOC entry 4868 (class 2606 OID 16505)
-- Name: pbx_fs pbx_fs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pbx_fs
    ADD CONSTRAINT pbx_fs_pkey PRIMARY KEY (id);


--
-- TOC entry 4870 (class 2606 OID 16512)
-- Name: port_setting port_setting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.port_setting
    ADD CONSTRAINT port_setting_pkey PRIMARY KEY (id);


--
-- TOC entry 4872 (class 2606 OID 16519)
-- Name: registrationnumbers registrationnumbers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrationnumbers
    ADD CONSTRAINT registrationnumbers_pkey PRIMARY KEY (number);


--
-- TOC entry 4874 (class 2606 OID 16526)
-- Name: subscriber subscriber_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subscriber
    ADD CONSTRAINT subscriber_pkey PRIMARY KEY (id);


--
-- TOC entry 4876 (class 2606 OID 16555)
-- Name: subscriber_profile subscriber_profile_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subscriber_profile
    ADD CONSTRAINT subscriber_profile_pkey PRIMARY KEY (id);


-- Completed on 2025-08-30 16:08:18

--
-- PostgreSQL database dump complete
--

\unrestrict aTIOkdnVk0fHgIRKdf1JsFClJJUNGgSmiTsOGp5hs8Bem9WYIvGHDMlIOr9Tn3v

