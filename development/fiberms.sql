--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: Apartment; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "Apartment" (
    id integer NOT NULL,
    "OpenGIS" point,
    number character varying(6),
    name text,
    "Building" integer,
    other text
);


--
-- Name: TABLE "Apartment"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "Apartment" IS 'Адреса.';


--
-- Name: COLUMN "Apartment".name; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "Apartment".name IS 'Номер назва кімнати (машинна кімната ліфту, кімната на техповерсі та т.і.)';


--
-- Name: COLUMN "Apartment".other; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "Apartment".other IS 'номер подъезда, название заведения, и т.д.';


--
-- Name: Apartment_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "Apartment_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Apartment_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "Apartment_id_seq" OWNED BY "Apartment".id;


--
-- Name: Building; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "Building" (
    id integer NOT NULL,
    "OpenGIS" polygon,
    "SettlementGeoSite" integer,
    "BuildingType" integer
);


--
-- Name: Building_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "Building_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Building_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "Building_id_seq" OWNED BY "Building".id;


--
-- Name: CableLine; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "CableLine" (
    id integer NOT NULL,
    "OpenGIS" path,
    "CableType" integer,
    length integer,
    comment text,
    name character varying(30) DEFAULT ''::character varying NOT NULL
);


--
-- Name: TABLE "CableLine"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "CableLine" IS 'Кабельные линии.';


--
-- Name: COLUMN "CableLine".length; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "CableLine".length IS 'Тимчасове поле. В подальшому буде вираховуватися.';


--
-- Name: CableLinePoint; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "CableLinePoint" (
    id integer NOT NULL,
    "OpenGIS" point,
    "CableLine" integer,
    "meterSign" integer,
    "NetworkNode" integer,
    note text,
    "Apartment" integer,
    "Building" integer,
    "SettlementGeoSpatial" integer,
    sequence integer
);


--
-- Name: TABLE "CableLinePoint"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "CableLinePoint" IS 'Дані про точки кабельної лінії.';


--
-- Name: CableLinePoint_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "CableLinePoint_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CableLinePoint_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "CableLinePoint_id_seq" OWNED BY "CableLinePoint".id;


SET default_with_oids = false;

--
-- Name: CableLine_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "CableLine_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CableLine_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "CableLine_id_seq" OWNED BY "CableLine".id;


SET default_with_oids = true;

--
-- Name: CableType; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "CableType" (
    id integer NOT NULL,
    marking character varying(30),
    manufacturer character varying(30),
    "tubeQuantity" integer,
    "fiberPerTube" integer,
    "tensileStrength" integer,
    diameter integer,
    comment text
);


--
-- Name: TABLE "CableType"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "CableType" IS 'Типы кабелей';


--
-- Name: COLUMN "CableType"."tensileStrength"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "CableType"."tensileStrength" IS 'Зазначається у кілоНьютонах';


--
-- Name: CableType_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "CableType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: CableType_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "CableType_id_seq" OWNED BY "CableType".id;


--
-- Name: FiberSpliceOrganizer; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "FiberSpliceOrganizer" (
    id integer NOT NULL,
    "FiberSpliceOrganizationType" integer
);


--
-- Name: FiberSpliceOrganizerType; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "FiberSpliceOrganizerType" (
    id integer NOT NULL,
    marking character varying(20),
    manufacturer character varying(20),
    note text
);


--
-- Name: FiberSpliceOrganizerType_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "FiberSpliceOrganizerType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: FiberSpliceOrganizerType_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "FiberSpliceOrganizerType_id_seq" OWNED BY "FiberSpliceOrganizerType".id;


SET default_with_oids = false;

--
-- Name: FiberSpliceOrganizer_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "FiberSpliceOrganizer_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: FiberSpliceOrganizer_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "FiberSpliceOrganizer_id_seq" OWNED BY "FiberSpliceOrganizer".id;


SET default_with_oids = true;

--
-- Name: IPaddress; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "IPaddress" (
    id integer NOT NULL,
    address inet,
    "IPaddressSpace" integer,
    comment text,
    "ParentNetwork" bigint
);


--
-- Name: COLUMN "IPaddress"."ParentNetwork"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "IPaddress"."ParentNetwork" IS 'Належніть до IP мережі';


--
-- Name: IPaddressOperator; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "IPaddressOperator" (
    id integer NOT NULL,
    name character varying(50),
    "Organization" integer
);


--
-- Name: TABLE "IPaddressOperator"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "IPaddressOperator" IS 'Оператори IP мереж. Створено для збереження відомостей про розподіл адрес операторами, які можуть повторюватися.';


--
-- Name: COLUMN "IPaddressOperator"."Organization"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "IPaddressOperator"."Organization" IS 'Повинно посилатися на таблицю з описом організацій.';


--
-- Name: IPaddressOperator_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "IPaddressOperator_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IPaddressOperator_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "IPaddressOperator_id_seq" OWNED BY "IPaddressOperator".id;


--
-- Name: IPaddressSpace; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "IPaddressSpace" (
    id integer NOT NULL,
    "IPaddressOperator" integer,
    assign character varying(50)
);


--
-- Name: TABLE "IPaddressSpace"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "IPaddressSpace" IS 'Незалежні IP адресні простори в межах одного оператора, але призначені для забезпечення функціонування роздільних ділянок мереж, в яких можливо повторення IP адрес. Наприклад призначення так званих приватних мереж, однакові адреси яких можуть бути призначені декількам пристроям в обасті контролю оператора.';


--
-- Name: IPaddressSpace_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "IPaddressSpace_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IPaddressSpace_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "IPaddressSpace_id_seq" OWNED BY "IPaddressSpace".id;


--
-- Name: IPaddress_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "IPaddress_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: IPaddress_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "IPaddress_id_seq" OWNED BY "IPaddress".id;


--
-- Name: LogAdminActions; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "LogAdminActions" (
    id integer NOT NULL,
    "table" integer,
    record integer,
    "time" timestamp without time zone,
    action text,
    description text,
    admin integer NOT NULL
);


--
-- Name: TABLE "LogAdminActions"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "LogAdminActions" IS 'Операції адміністраторів над записами у БД';


--
-- Name: LogAdminActions_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "LogAdminActions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: LogAdminActions_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "LogAdminActions_id_seq" OWNED BY "LogAdminActions".id;


--
-- Name: LogTableList; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "LogTableList" (
    id integer NOT NULL,
    name text,
    description text
);


--
-- Name: TABLE "LogTableList"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "LogTableList" IS 'Відповідність ID таблиці в журналі та імені таблиці в БД';


--
-- Name: LogTableList_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "LogTableList_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: LogTableList_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "LogTableList_id_seq" OWNED BY "LogTableList".id;


SET default_with_oids = false;

--
-- Name: MapSessions; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "MapSessions" (
    id integer NOT NULL,
    "UserId" integer NOT NULL,
    "LastAction" timestamp without time zone NOT NULL
);


--
-- Name: MapSessions_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "MapSessions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: MapSessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "MapSessions_id_seq" OWNED BY "MapSessions".id;


--
-- Name: MapSettings; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "MapSettings" (
    "LastChangedMap" timestamp without time zone NOT NULL,
    "LastChangedTmpMap" timestamp without time zone NOT NULL,
    id integer NOT NULL
);


SET default_with_oids = true;

--
-- Name: NetworkBox; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "NetworkBox" (
    id integer NOT NULL,
    "NetworkBoxType" integer,
    "inventoryNumber" integer
);


--
-- Name: TABLE "NetworkBox"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "NetworkBox" IS 'Для забезпечення можливості збереження даних які стосуються кожного окремого виробу.';


--
-- Name: NetworkBoxType; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "NetworkBoxType" (
    id integer NOT NULL,
    marking character varying(20),
    manufacturer character varying(30),
    units integer,
    width integer,
    height integer,
    length integer,
    diameter integer
);


--
-- Name: NetworkBoxType_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "NetworkBoxType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: NetworkBoxType_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "NetworkBoxType_id_seq" OWNED BY "NetworkBoxType".id;


SET default_with_oids = false;

--
-- Name: NetworkBox_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "NetworkBox_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: NetworkBox_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "NetworkBox_id_seq" OWNED BY "NetworkBox".id;


SET default_with_oids = true;

--
-- Name: NetworkNode; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "NetworkNode" (
    id integer NOT NULL,
    "OpenGIS" point,
    name name NOT NULL,
    "NetworkBox" integer,
    note text,
    "SettlementGeoSpatial" integer,
    "Building" integer,
    "Apartment" integer
);


--
-- Name: TABLE "NetworkNode"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "NetworkNode" IS 'Узлы сети.';


--
-- Name: COLUMN "NetworkNode"."SettlementGeoSpatial"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "NetworkNode"."SettlementGeoSpatial" IS 'Не потрібно заповнювати, якщо є відомості про будівлю.';


--
-- Name: COLUMN "NetworkNode"."Building"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "NetworkNode"."Building" IS 'Не потрібно заповнювати, якщо є відомості про апартаменти.';


--
-- Name: NetworkNode_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "NetworkNode_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: NetworkNode_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "NetworkNode_id_seq" OWNED BY "NetworkNode".id;


SET default_with_oids = false;

--
-- Name: OpticalFiber; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "OpticalFiber" (
    id integer NOT NULL,
    "CableLine" integer NOT NULL,
    fiber integer NOT NULL,
    note text
);


--
-- Name: OpticalFiberJoin; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "OpticalFiberJoin" (
    id integer NOT NULL,
    "OpticalFiber" integer NOT NULL,
    "OpticalFiberSplice" integer NOT NULL
);


--
-- Name: TABLE "OpticalFiberJoin"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "OpticalFiberJoin" IS 'Таблиця з''єднань оптичних волокон';


--
-- Name: opticalFiberJoin_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "opticalFiberJoin_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: opticalFiberJoin_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "opticalFiberJoin_id_seq" OWNED BY "OpticalFiberJoin".id;


--
-- Name: OpticalFiberSplice; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "OpticalFiberSplice" (
    id integer NOT NULL,
    "NetworkNode" integer NOT NULL,
    attenuation integer,
    note text,
    "FiberSpliceOrganizer" integer
);


--
-- Name: TABLE "OpticalFiberSplice"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "OpticalFiberSplice" IS 'Оптичні зварювання';


--
-- Name: OpticalFiberSplice_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "OpticalFiberSplice_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: OpticalFiberSplice_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "OpticalFiberSplice_id_seq" OWNED BY "OpticalFiberSplice".id;


--
-- Name: OpticalFiber_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "OpticalFiber_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: OpticalFiber_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "OpticalFiber_id_seq" OWNED BY "OpticalFiber".id;


SET default_with_oids = true;

--
-- Name: SettlementGeoSite; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "SettlementGeoSite" (
    id integer NOT NULL,
    "OpenGIS" polygon,
    number character varying(5),
    corps integer,
    "SettlementGeoSpatial" integer,
    note text
);


--
-- Name: TABLE "SettlementGeoSite"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "SettlementGeoSite" IS 'Ділянки які наділені поштовою адресою.';


--
-- Name: COLUMN "SettlementGeoSite"."SettlementGeoSpatial"; Type: COMMENT; Schema: public
--

COMMENT ON COLUMN "SettlementGeoSite"."SettlementGeoSpatial" IS 'Для оптимізації обчислювалних потужностей. В майбутньому можливо визначати за допомогою розрахунків перетинання областей.';


--
-- Name: SettlementGeoSite_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "SettlementGeoSite_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: SettlementGeoSite_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "SettlementGeoSite_id_seq" OWNED BY "SettlementGeoSite".id;


--
-- Name: SettlementGeoSpatial; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "SettlementGeoSpatial" (
    id integer NOT NULL,
    "OpenGIS" polygon,
    name character varying(30),
    "settlementGeoSpatialType" character varying(20)
);


--
-- Name: TABLE "SettlementGeoSpatial"; Type: COMMENT; Schema: public
--

COMMENT ON TABLE "SettlementGeoSpatial" IS 'Географічні об’єкти населених пунктів. (улица, площадь, проспект, переулок, бульвар, шоссе, набережная, тупик, проезд, аллея, мост, путепровод, эстакада, парк, сквер, река, озеро, пруд, гора, возвышенность, и др.)';


--
-- Name: SettlementGeoSpatialAlias; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "SettlementGeoSpatialAlias" (
    id integer NOT NULL,
    name character varying(25),
    "SettlementGeoSpatial" bigint NOT NULL
);


--
-- Name: SettlementGeoSpatialAlias_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "SettlementGeoSpatialAlias_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: SettlementGeoSpatialAlias_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "SettlementGeoSpatialAlias_id_seq" OWNED BY "SettlementGeoSpatialAlias".id;


--
-- Name: SettlementGeoSpatial_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "SettlementGeoSpatial_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: SettlementGeoSpatial_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "SettlementGeoSpatial_id_seq" OWNED BY "SettlementGeoSpatial".id;


--
-- Name: Users; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE "Users" (
    id integer NOT NULL,
    username character varying(15) NOT NULL,
    password character varying(50) NOT NULL,
    token character varying(50),
    class character varying(1) DEFAULT 2
);
ALTER TABLE ONLY "Users" ALTER COLUMN class SET STORAGE PLAIN;


--
-- Name: Users_id_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE "Users_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: Users_id_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE "Users_id_seq" OWNED BY "Users".id;


SET default_with_oids = false;

--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "Apartment" ALTER COLUMN id SET DEFAULT nextval('"Apartment_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "Building" ALTER COLUMN id SET DEFAULT nextval('"Building_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "CableLine" ALTER COLUMN id SET DEFAULT nextval('"CableLine_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint" ALTER COLUMN id SET DEFAULT nextval('"CableLinePoint_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "CableType" ALTER COLUMN id SET DEFAULT nextval('"CableType_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "FiberSpliceOrganizer" ALTER COLUMN id SET DEFAULT nextval('"FiberSpliceOrganizer_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "FiberSpliceOrganizerType" ALTER COLUMN id SET DEFAULT nextval('"FiberSpliceOrganizerType_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "IPaddress" ALTER COLUMN id SET DEFAULT nextval('"IPaddress_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "IPaddressOperator" ALTER COLUMN id SET DEFAULT nextval('"IPaddressOperator_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "IPaddressSpace" ALTER COLUMN id SET DEFAULT nextval('"IPaddressSpace_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "LogAdminActions" ALTER COLUMN id SET DEFAULT nextval('"LogAdminActions_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "LogTableList" ALTER COLUMN id SET DEFAULT nextval('"LogTableList_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "MapSessions" ALTER COLUMN id SET DEFAULT nextval('"MapSessions_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "NetworkBox" ALTER COLUMN id SET DEFAULT nextval('"NetworkBox_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "NetworkBoxType" ALTER COLUMN id SET DEFAULT nextval('"NetworkBoxType_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "NetworkNode" ALTER COLUMN id SET DEFAULT nextval('"NetworkNode_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "OpticalFiber" ALTER COLUMN id SET DEFAULT nextval('"OpticalFiber_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberJoin" ALTER COLUMN id SET DEFAULT nextval('"opticalFiberJoin_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberSplice" ALTER COLUMN id SET DEFAULT nextval('"OpticalFiberSplice_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "SettlementGeoSite" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSite_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "SettlementGeoSpatial" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSpatial_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSpatialAlias_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY "Users" ALTER COLUMN id SET DEFAULT nextval('"Users_id_seq"'::regclass);


--
-- Name: Apartment_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "Apartment"
    ADD CONSTRAINT "Apartment_pk" PRIMARY KEY (id);


--
-- Name: Building_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "Building"
    ADD CONSTRAINT "Building_pk" PRIMARY KEY (id);


--
-- Name: CableLinePoint_CableLine_NetworkNode_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_NetworkNode_key" UNIQUE ("CableLine", "NetworkNode");


--
-- Name: CableLinePoint_CableLine_meterSign_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_meterSign_key" UNIQUE ("CableLine", "meterSign");


--
-- Name: CableLinePoint_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_pk" PRIMARY KEY (id);


--
-- Name: CableLine_name_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_name_key" UNIQUE (name);


--
-- Name: CableLine_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_pkey" PRIMARY KEY (id);


--
-- Name: CableType_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "CableType"
    ADD CONSTRAINT "CableType_pkey" PRIMARY KEY (id);


--
-- Name: FiberSpliceOrganizerType_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "FiberSpliceOrganizerType"
    ADD CONSTRAINT "FiberSpliceOrganizerType_pk" PRIMARY KEY (id);


--
-- Name: FiberSpliceOrganizer_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "FiberSpliceOrganizer"
    ADD CONSTRAINT "FiberSpliceOrganizer_pk" PRIMARY KEY (id);


--
-- Name: IPaddressSpace_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "IPaddressSpace"
    ADD CONSTRAINT "IPaddressSpace_pkey" PRIMARY KEY (id);


--
-- Name: IPaddress_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "IPaddress"
    ADD CONSTRAINT "IPaddress_pkey" PRIMARY KEY (id);


--
-- Name: IPoperator_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "IPaddressOperator"
    ADD CONSTRAINT "IPoperator_pkey" PRIMARY KEY (id);


--
-- Name: LogAdminActions_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_pk" PRIMARY KEY (id);


--
-- Name: LogTableList_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "LogTableList"
    ADD CONSTRAINT "LogTableList_pk" PRIMARY KEY (id);


--
-- Name: MapSessions_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "MapSessions"
    ADD CONSTRAINT "MapSessions_pkey" PRIMARY KEY (id);


--
-- Name: MapSessions_ukey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "MapSessions"
    ADD CONSTRAINT "MapSessions_ukey" UNIQUE ("UserId");


--
-- Name: MapSettings_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "MapSettings"
    ADD CONSTRAINT "MapSettings_pkey" PRIMARY KEY (id);


--
-- Name: NetworkBoxType_marking_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkBoxType"
    ADD CONSTRAINT "NetworkBoxType_marking_key" UNIQUE (marking);


--
-- Name: NetworkBoxType_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkBoxType"
    ADD CONSTRAINT "NetworkBoxType_pk" PRIMARY KEY (id);


--
-- Name: NetworkBox_inventoryNumber_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_inventoryNumber_key" UNIQUE ("inventoryNumber");


--
-- Name: NetworkBox_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_pk" PRIMARY KEY (id);


--
-- Name: NetworkNode_NetworkBox_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_NetworkBox_key" UNIQUE ("NetworkBox");


--
-- Name: NetworkNode_name_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_name_key" UNIQUE (name);


--
-- Name: NetworkNode_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_pkey" PRIMARY KEY (id);


--
-- Name: OpticalFiberSplice_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_pkey" PRIMARY KEY (id);


--
-- Name: OpticalFiber_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "OpticalFiber"
    ADD CONSTRAINT "OpticalFiber_pkey" PRIMARY KEY (id);


--
-- Name: SettlementGeoSite_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "SettlementGeoSite"
    ADD CONSTRAINT "SettlementGeoSite_pk" PRIMARY KEY (id);


--
-- Name: SettlementGeoSpatialAlias_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias"
    ADD CONSTRAINT "SettlementGeoSpatialAlias_pk" PRIMARY KEY (id);


--
-- Name: SettlementGeoSpatial_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "SettlementGeoSpatial"
    ADD CONSTRAINT "SettlementGeoSpatial_pk" PRIMARY KEY (id);


--
-- Name: Users_pk; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_pk" PRIMARY KEY (id);


--
-- Name: opticalFiberJoin_OpticalFiber_OpticalFiberSplice_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiber_OpticalFiberSplice_key" UNIQUE ("OpticalFiber", "OpticalFiberSplice");


--
-- Name: opticalFiberJoin_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_pkey" PRIMARY KEY (id);


--
-- Name: Address_apartment_key; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "Address_apartment_key" ON "Apartment" USING btree (name, other);


--
-- Name: CableLinePoint_CableLine_sequence; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "CableLinePoint_CableLine_sequence" ON "CableLinePoint" USING btree ("CableLine", sequence);


--
-- Name: CableType_marking_key; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "CableType_marking_key" ON "CableType" USING btree (marking);


--
-- Name: IPaddress_address_key; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "IPaddress_address_key" ON "IPaddress" USING btree (address);


--
-- Name: LogTableList_name; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "LogTableList_name" ON "LogTableList" USING btree (name);


--
-- Name: OpticalFiber_CableLine_fiber; Type: INDEX; Schema: public; Tablespace: 
--

CREATE UNIQUE INDEX "OpticalFiber_CableLine_fiber" ON "OpticalFiber" USING btree ("CableLine", fiber);


--
-- Name: Apartment_Building_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "Apartment"
    ADD CONSTRAINT "Apartment_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: Building_SettlementGeoSite_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "Building"
    ADD CONSTRAINT "Building_SettlementGeoSite_fkey" FOREIGN KEY ("SettlementGeoSite") REFERENCES "SettlementGeoSite"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLinePoint_Apartment_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLinePoint_Building_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLinePoint_CableLine_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_fkey" FOREIGN KEY ("CableLine") REFERENCES "CableLine"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLinePoint_NetworkNode_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_NetworkNode_fkey" FOREIGN KEY ("NetworkNode") REFERENCES "NetworkNode"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLinePoint_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: CableLine_CableType_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_CableType_fkey" FOREIGN KEY ("CableType") REFERENCES "CableType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "FiberSpliceOrganizer"
    ADD CONSTRAINT "FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey" FOREIGN KEY ("FiberSpliceOrganizationType") REFERENCES "FiberSpliceOrganizerType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: IPaddressSpace_IPaddressOperator_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "IPaddressSpace"
    ADD CONSTRAINT "IPaddressSpace_IPaddressOperator_fkey" FOREIGN KEY ("IPaddressOperator") REFERENCES "IPaddressOperator"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: IPaddress_IPaddressSpace_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "IPaddress"
    ADD CONSTRAINT "IPaddress_IPaddressSpace_fkey" FOREIGN KEY ("IPaddressSpace") REFERENCES "IPaddressSpace"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: LogAdminActions_admin_fk; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_admin_fk" FOREIGN KEY (admin) REFERENCES "Users"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: LogAdminActions_table_fk; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_table_fk" FOREIGN KEY ("table") REFERENCES "LogTableList"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: NetworkBox_NetworkBoxType_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_NetworkBoxType_fkey" FOREIGN KEY ("NetworkBoxType") REFERENCES "NetworkBoxType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: NetworkNode_Apartment_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: NetworkNode_Building_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: NetworkNode_NetworkBox_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_NetworkBox_fkey" FOREIGN KEY ("NetworkBox") REFERENCES "NetworkBox"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: NetworkNode_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: OpticalFiberSplice_FiberSpliceOrganizer_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_FiberSpliceOrganizer_fkey" FOREIGN KEY ("FiberSpliceOrganizer") REFERENCES "FiberSpliceOrganizer"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: OpticalFiberSplice_NetworkNode_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_NetworkNode_fkey" FOREIGN KEY ("NetworkNode") REFERENCES "NetworkNode"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: OpticalFiber_CableLine_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "OpticalFiber"
    ADD CONSTRAINT "OpticalFiber_CableLine_fkey" FOREIGN KEY ("CableLine") REFERENCES "CableLine"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: SettlementGeoSite_fkey1; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "SettlementGeoSite"
    ADD CONSTRAINT "SettlementGeoSite_fkey1" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias"
    ADD CONSTRAINT "SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: opticalFiberJoin_OpticalFiberSplice_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiberSplice_fkey" FOREIGN KEY ("OpticalFiberSplice") REFERENCES "OpticalFiberSplice"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: opticalFiberJoin_OpticalFiber_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiber_fkey" FOREIGN KEY ("OpticalFiber") REFERENCES "OpticalFiber"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


INSERT INTO "Users" VALUES (1, 'admin', 'd4f02db936f820f977dfde0eb98aa03b', 'bc5290e3584b6b558ec0fd4c6d051fb4', '1');

INSERT INTO "LogTableList" VALUES (1, 'CableType', NULL);
INSERT INTO "LogTableList" VALUES (2, 'CableLine', NULL);
INSERT INTO "LogTableList" VALUES (3, 'CableLinePoint', NULL);
INSERT INTO "LogTableList" VALUES (4, 'NetworkBoxType', NULL);
INSERT INTO "LogTableList" VALUES (5, 'NetworkBox', NULL);
INSERT INTO "LogTableList" VALUES (6, 'NetworkNode', NULL);
INSERT INTO "LogTableList" VALUES (7, 'FiberSplice', NULL);
INSERT INTO "LogTableList" VALUES (8, 'FiberSpliceOrganizer', NULL);
INSERT INTO "LogTableList" VALUES (9, 'FiberSpliceOrganizerType', NULL);
INSERT INTO "LogTableList" VALUES (10, 'OpticalFiber', NULL);
INSERT INTO "LogTableList" VALUES (11, 'OpticalFiberJoin', NULL);
INSERT INTO "LogTableList" VALUES (12, 'OpticalFiberSplice', NULL);

INSERT INTO "MapSettings"  VALUES (NOW(), NOW(), 1);

--
-- PostgreSQL database dump complete
--

