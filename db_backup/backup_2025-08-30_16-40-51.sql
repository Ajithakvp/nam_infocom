--
-- PostgreSQL database dump
--

\restrict 4BJELmYhNdhl4EyrQy8ua4cpx9OCrdFBWaJvacqBBlUpvBRabyzqMa8UFtqw3dj

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

-- Started on 2025-08-30 16:40:51

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
-- TOC entry 5022 (class 0 OID 16401)
-- Dependencies: 217
-- Data for Name: agent_cdr; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agent_cdr (callid, fromnumber, tonumber, callstarttime, callendtime, callduration, calltype, calldirection, callstatus, recordingurl, notes, fromcountry, tocountry, filename, call_types) FROM stdin;
\.


--
-- TOC entry 5024 (class 0 OID 16407)
-- Dependencies: 219
-- Data for Name: agent_contacts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agent_contacts (contactid, firstname, lastname, email, phonenumber, address, city, state, zipcode, createddate) FROM stdin;
\.


--
-- TOC entry 5026 (class 0 OID 16417)
-- Dependencies: 221
-- Data for Name: agent_subscriber_profile; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agent_subscriber_profile (first_name, last_name, subscriber_id, country_code, mobile_no, subscriber_password, activated_date, expiry_date, res_no, email, company_name, addr_1, addr_2, city, state, country, designation, area_code, office_no, extension_no, email_notification_sent, sms_notification_sent, groupid, smssent, profile, pbx, status, timezone, timedifference, gmtsign, daylightsaving, dststartmonth, dststartdate, dstendmonth, dstenddate, imsino, ipphoneno, mobileuser, landlineuser, ipphoneuser, mobionuser, license_type, days_of_validity, action_date, id) FROM stdin;
\.


--
-- TOC entry 5028 (class 0 OID 16426)
-- Dependencies: 223
-- Data for Name: agent_useractivity; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.agent_useractivity (id, subscriber_id, mobile_no, action, regstatus, "timestamp") FROM stdin;
\.


--
-- TOC entry 5029 (class 0 OID 16435)
-- Dependencies: 224
-- Data for Name: call_details_fs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.call_details_fs (subscriber_id, call_ref_id, calling_number, called_number, call_type, call_offer_time, call_connected_time, call_disconnected_time, call_duration, calling_no_ip, called_no_ip, imei_no, imsi_no, disconnected_reason, network_mode, calling_number_city, called_number_city, calling_number_country, called_number_country, cas_export_f, bwinmb, calltype, filename, filesize, im_message_time, reason, groupid, missedcallstatus, callednumbernetworkmode, conferenceid, message, encryption, groupname) FROM stdin;
9445346291	94453462911729752203	9445346291	9176066606	Outgoing	2024-10-24 12:13:23	2024-10-24 12:13:23	2024-10-24 12:13:30	0					Normal Disconnect	0							1			2024-10-24 12:13:23	Normal Disconnect		0	0			0	
9445346291	94453462911729752220	9445346291	9176066606	Incoming	2024-10-24 12:13:40	2024-10-24 12:13:40	2024-10-24 12:13:47	5					Normal Disconnect	0							1			2024-10-24 12:13:40	Normal Disconnect		0	0			0	
9445346291	94453462911729752218	9445346291	9176066606	Outgoing	2024-10-24 12:13:38	2024-10-24 12:13:38	2024-10-24 12:13:45	5					Normal Disconnect	0							1			2024-10-24 12:13:38	Normal Disconnect		0	0			0	
9445346291	94453462911729752229	9445346291	9176066606	Incoming	2024-10-24 12:13:49	2024-10-24 12:13:49	2024-10-24 12:14:02	11					Normal Disconnect	0							2			2024-10-24 12:13:49	Normal Disconnect		0	0			0	
9445346291	94453462911729752227	9445346291	9176066606	Outgoing	2024-10-24 12:13:47	2024-10-24 12:13:47	2024-10-24 12:14:01	12					Normal Disconnect	0							6			2024-10-24 12:13:47	Normal Disconnect		0	0			0	
9445346291	94453462911729752246	9445346291	9176066606	Incoming	2024-10-24 12:14:06	2024-10-24 12:14:06	2024-10-24 12:14:10	2					Normal Disconnect	0							1			2024-10-24 12:14:06	Normal Disconnect		0	0			0	
9445346291	94453462911729752244	9445346291	9176066606	Outgoing	2024-10-24 12:14:04	2024-10-24 12:14:04	2024-10-24 12:14:09	3					Normal Disconnect	0							5			2024-10-24 12:14:04	Normal Disconnect		0	0			0	
9445346291	94453462911729752263	9445346291	9176066606	Incoming	2024-10-24 12:14:23	2024-10-24 12:14:23	2024-10-24 12:14:27	2					Normal Disconnect	0							1			2024-10-24 12:14:23	Normal Disconnect		0	0			0	
9445346291	94453462911729752261	9445346291	9176066606	Outgoing	2024-10-24 12:14:21	2024-10-24 12:14:21	2024-10-24 12:14:25	2					Normal Disconnect	0							2			2024-10-24 12:14:21	Normal Disconnect		0	0			0	
9445346291	94453462911729752282	9445346291	9176066606	PBX	2024-10-24 12:14:42	2025-04-24 12:14:42	2024-10-24 12:14:49	5					Normal Disconnect	0							2			2024-10-24 12:14:42	Normal Disconnect		0	0			0	
\.


--
-- TOC entry 5031 (class 0 OID 16441)
-- Dependencies: 226
-- Data for Name: chats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chats (chatid, senderid, receiverid, message, sentat, isread, attachment, attachmentname, attachmenttype, ftp_url, attachmentsize) FROM stdin;
\.


--
-- TOC entry 5032 (class 0 OID 16451)
-- Dependencies: 227
-- Data for Name: click2call_cdr; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.click2call_cdr (callid, fromnumber, tonumber, callstarttime, callendtime, callduration, calltype, callstatus, recordingurl, notes, fromcountry, tocountry, filename) FROM stdin;
\.


--
-- TOC entry 5034 (class 0 OID 16457)
-- Dependencies: 229
-- Data for Name: conference_layouts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.conference_layouts (layoutname, action_date, id) FROM stdin;
1x1	\N	1
1x2	\N	2
2x1	\N	3
2x1-zoom	\N	4
3x1-zoom	\N	5
5-grid-zoom	\N	6
3x2-zoom	\N	7
7-grid-zoom	\N	8
4x2-zoom	\N	9
1x1+2x1	\N	10
2x2	\N	11
3x3	\N	12
4x4	\N	13
5x5	\N	14
6*6	\N	15
8*8	\N	16
\.


--
-- TOC entry 5035 (class 0 OID 16463)
-- Dependencies: 230
-- Data for Name: gps_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.gps_details (mobile_number, latitude, longitude, name, action_date, department) FROM stdin;
\.


--
-- TOC entry 5037 (class 0 OID 16469)
-- Dependencies: 232
-- Data for Name: group_setting; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.group_setting (group_number, action_date, id, group_name, conference, user_details, calltype, moderate) FROM stdin;
3499	2025-03-31 11:52:13.28	2	Madhan Conference	Video	Madhan Anandan-7339260551,nishanth pic-7845470737	Dial-IN	
5000	2025-03-31 13:13:16.72	3	Audio Only	Audio	Madhan Anandan-7339260551,nishanth pic-7845470737	Dial-IN	
3501	2025-08-07 16:09:25.387	4	Video Dial Out	Video	Ashok Rajan-7339318185,Murugan ganapathy NAM-9789904975	Dial-OUT	Madhan Anandan-7339260551
3600	2025-08-21 11:16:24.247	5	Police Conf	Video	Ashok Rajan-7339318185,Dhivya suresh-9176066606,Leo Dass-6384300737,Nam jio2-9344746931	Dial-OUT	nishanth pic-7845470737
5000	\N	6	TEST	Audio	Magesh - 8680986859,Ezhil - 9500339361		
3000	\N	7	TEST	Video	Ezhil - 9500339361,Kiran - 8825559605	Dial-IN	
3500	\N	8	TEST	Video	Magesh - 8680986859,Ezhil - 9500339361,Kiran - 8825559605	Dial-OUT	Arunan - 9841049107
3501	2025-08-28 18:24:42.149	9	TEST 123	Video	Magesh - 8680986859,Ezhil - 9500339361,Kiran - 8825559605,Ashok - 7339318185,Sangeetha - 8807938378,Porkalai - 7550375730	Dial-OUT	Dhivya - 9176066606
3000	2025-08-28 18:29:46.069	10	Video Call	Video	Magesh - 8680986859	Dial-IN	
5000	2025-08-28 18:43:30.249	12	TEST	Audio	Ezhil - 9500339361		
\.


--
-- TOC entry 5039 (class 0 OID 16478)
-- Dependencies: 234
-- Data for Name: ip_setting; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ip_setting (ip_name, ip_address, action_date, id) FROM stdin;
Internal_Rtp_IP & Sip_IP	10.185.13.23	\N	6
External_Rtp_IP & Sip_IPAD	10.185.13.24	\N	5
\.


--
-- TOC entry 5041 (class 0 OID 16485)
-- Dependencies: 236
-- Data for Name: layout_setting; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.layout_setting (layoutnumber, action_date, id) FROM stdin;
5-grid-zoom	\N	1
\.


--
-- TOC entry 5042 (class 0 OID 16491)
-- Dependencies: 237
-- Data for Name: mobiweb_cdr; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mobiweb_cdr (callid, fromnumber, tonumber, callstarttime, callendtime, callduration, calltype, calldirection, callstatus, recordingurl, notes, fromcountry, tocountry, filename, call_types) FROM stdin;
2025030613032479758	9176066606	007550375730	2025-03-06 13:01:16	2025-03-06 13:03:24	00:02:05	video	outgoing	Call terminated	\N	\N			\N	Mobion
2025030613051605461	8825559605	117550375730	2025-03-06 13:05:02	2025-03-06 13:05:16	00:00:10	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030613054614461	8825559605	118680986859	2025-03-06 13:05:26	2025-03-06 13:05:46	00:00:10	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030613062035261	8825559605	117339318185	2025-03-06 13:05:53	2025-03-06 13:06:20	00:00:00	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030613063589561	8825559605	117339318185	2025-03-06 13:06:28	2025-03-06 13:06:35	00:00:02	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030613071734858	9176066606	118825559605	2025-03-06 13:07:13	2025-03-06 13:07:17	00:00:01	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030613080669058	9176066606	117339318185	2025-03-06 13:07:56	2025-03-06 13:08:06	00:00:08	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
2025030614452118758	9176066606	008825559605	2025-03-06 14:45:20	2025-03-06 14:45:21	00:00:00	audio	outgoing	Not Found	\N	\N			\N	Mobion
2025030614453201758	9176066606	008825559605	2025-03-06 14:45:30	2025-03-06 14:45:32	00:00:00	video	outgoing	Not Found	\N	\N			\N	Mobion
2025030614520481258	9176066606	118825559605	2025-03-06 14:51:42	2025-03-06 14:52:04	00:00:19	audio	outgoing	Call terminating...	\N	\N			\N	GSMCall
\.


--
-- TOC entry 5043 (class 0 OID 16496)
-- Dependencies: 238
-- Data for Name: pbx_cdr; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pbx_cdr (call_reference_no, from_number, to_number, dialed_time, call_connected_time, call_disconnected_time, status) FROM stdin;
\.


--
-- TOC entry 5045 (class 0 OID 16500)
-- Dependencies: 240
-- Data for Name: pbx_fs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pbx_fs (id, name, designation, country, extension_number) FROM stdin;
\.


--
-- TOC entry 5047 (class 0 OID 16507)
-- Dependencies: 242
-- Data for Name: port_setting; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.port_setting (portnumber, portname, action_date, id) FROM stdin;
504	Internal_Tls_Port	\N	2
502	Internal_Sip_Port	\N	4
501	WSS_Port	\N	5
105	External_Sip_Port	\N	3
506	External_Tls_PortTL	\N	1
\.


--
-- TOC entry 5048 (class 0 OID 16513)
-- Dependencies: 243
-- Data for Name: registrationnumbers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.registrationnumbers (number, status, lastupdated) FROM stdin;
1233	Unregistered	2025-12-07 00:00:00
\.


--
-- TOC entry 5050 (class 0 OID 16521)
-- Dependencies: 245
-- Data for Name: subscriber; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subscriber (subscriber_id, password, action_date, id) FROM stdin;
Default	ivrs@123	\N	1
\.


--
-- TOC entry 5054 (class 0 OID 16548)
-- Dependencies: 249
-- Data for Name: subscriber_profile; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subscriber_profile (id, first_name, last_name, subscriber_id, country_code, mobile_no, subscriber_password, activated_date, expiry_date, res_no, email, company_name, addr_1, addr_2, city, state, country, designation, area_code, office_no, extension_no, email_notification_sent, sms_notification_sent, groupid, smssent, profile, pbx, status, timezone, timedifference, gmtsign, daylightsaving, dststartmonth, dststartdate, dstendmonth, dstenddate, imsino, ipphoneno, mobileuser, landlineuser, ipphoneuser, mobionuser, license_type, days_of_validity, action_date, mobion, mobiweb) FROM stdin;
1	\N	\N	admin	\N	\N	admin	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	Admin	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0	0	0	0	\N	\N	\N	\N	\N
4	Magesh	Kumar	8680986859	+91	8680986859	8680986859	\N	\N		mageshkumar.r@naminfocom.com			\N	Chennai		India			\N		\N	\N		0	User	24	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	1018	0	0	0	0	\N	\N	2025-04-05 15:49:24.473	\N	\N
5	Ezhil	arasan	9500339361	+91	9500339361	9500339361	\N	\N	\N	ezhilarasan.p@naminfocom.com	\N	\N	\N	Tiruvannamalai	\N	India	\N	\N	\N	\N	\N	\N	\N	0	User	\N	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	\N	0	0	0	0	\N	\N	2025-01-07 12:04:35.227	\N	9500339361
6	Kiran	kumar	8825559605	+91	8825559605	8825559605	\N	\N		kiran.m@nam-it.com			\N	Chengalpattu		India			\N		\N	\N		0	User	30	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	1001	0	0	0	0	\N	\N	2025-04-05 15:50:26.303	\N	\N
7	Ashok	Rajan	7339318185	\N	7339318185	7339318185	\N	\N	\N	ashokrajan.k@naminfocom.com	\N	\N	\N	Tiruchirapalli	\N	India	\N	\N	\N	\N	\N	\N	\N	0	User	\N	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	\N	0	0	0	0	\N	\N	2025-01-07 12:06:28.267	7339318185	7339318185
8	Sangeetha	mani	8807938378	\N	8807938378	8807938378	\N	\N	\N	sangeetha.a@naminfocom.com	\N	\N	\N	chennai	\N	India	\N	\N	\N	\N	\N	\N	\N	0	User	\N	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	\N	0	0	0	0	\N	\N	2025-01-07 12:05:51.27	\N	\N
9	Porkalai	Ramesh	7550375730	\N	7550375730	7550375730	\N	\N		porkalai@naminfocom.com	NamInfoCom		\N	Ramanathapuram		India	Quality process Engineer		\N		\N	\N		0	User	23	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	1017	0	0	0	0	\N	\N	2025-04-05 15:49:11.763	\N	\N
3	Dhivya	suresh	9176066606	+91	9176066606	9176066606	\N	\N		dhivya.s@naminfocom.com			\N	Chennai		India			\N		\N	\N		0	admin	21	1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N	8825559605	0	0	0	0	\N	\N	2025-03-11 12:19:08.567	\N	\N
12	Test123445	123	test		9876543101	9876543101	2025-08-30 00:00:00	2026-08-30 00:00:00	ffff	test@gmail.com	gggg	ggddd	\N	gggg	ggtt	India	gggg	t55rrr	\N	rrrr	1	1	ggg	1	admin	ggg	1	UTC+05:30	\N	\N	1	\N	\N	\N	\N	\N	ggg	1	1	1	1223	standard	365	2025-08-30 00:08:38	1223	ggg`~'123fftt
2	Arunan1234	D NAM	9841049107	+91	9841049107	9841049107	\N	\N		arunan@naminfocom.com			\N	Chennai		India			\N	\N	\N	\N		0	admin		1	UTC+05:30	\N	\N	0	\N	\N	\N	\N	\N		0	0	0	0	\N	\N	2025-01-07 12:13:08.887		
\.


--
-- TOC entry 5051 (class 0 OID 16536)
-- Dependencies: 246
-- Data for Name: t_registered; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.t_registered (skey, namealias, nameoriginal, urlalias, urloriginal, acceptpattern, requester, expires, priority, timeupdate, expirestime, mappedport, awake, useragent, param) FROM stdin;
\.


--
-- TOC entry 5052 (class 0 OID 16541)
-- Dependencies: 247
-- Data for Name: takeconference_list; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.takeconference_list (from_number, to_number, conferenceid, action_date) FROM stdin;
\.


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


-- Completed on 2025-08-30 16:40:51

--
-- PostgreSQL database dump complete
--

\unrestrict 4BJELmYhNdhl4EyrQy8ua4cpx9OCrdFBWaJvacqBBlUpvBRabyzqMa8UFtqw3dj

