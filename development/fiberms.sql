--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.6
-- Dumped by pg_dump version 9.2.1
-- Started on 2013-01-17 16:46:23 EET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_with_oids = true;

--
-- TOC entry 162 (class 1259 OID 42054)
-- Name: Apartment; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3118 (class 0 OID 0)
-- Dependencies: 162
-- Name: TABLE "Apartment"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "Apartment" IS 'Адреса.';


--
-- TOC entry 3119 (class 0 OID 0)
-- Dependencies: 162
-- Name: COLUMN "Apartment".name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "Apartment".name IS 'Номер назва кімнати (машинна кімната ліфту, кімната на техповерсі та т.і.)';


--
-- TOC entry 3120 (class 0 OID 0)
-- Dependencies: 162
-- Name: COLUMN "Apartment".other; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "Apartment".other IS 'номер подъезда, название заведения, и т.д.';


--
-- TOC entry 161 (class 1259 OID 42052)
-- Name: Apartment_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Apartment_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3121 (class 0 OID 0)
-- Dependencies: 161
-- Name: Apartment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Apartment_id_seq" OWNED BY "Apartment".id;


--
-- TOC entry 194 (class 1259 OID 42212)
-- Name: Building; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "Building" (
    id integer NOT NULL,
    "OpenGIS" polygon,
    "SettlementGeoSite" integer,
    "BuildingType" integer
);


--
-- TOC entry 193 (class 1259 OID 42210)
-- Name: Building_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "Building_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3122 (class 0 OID 0)
-- Dependencies: 193
-- Name: Building_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "Building_id_seq" OWNED BY "Building".id;


--
-- TOC entry 166 (class 1259 OID 42077)
-- Name: CableLine; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3123 (class 0 OID 0)
-- Dependencies: 166
-- Name: TABLE "CableLine"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "CableLine" IS 'Кабельные линии.';


--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN "CableLine".length; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "CableLine".length IS 'Тимчасове поле. В подальшому буде вираховуватися.';


--
-- TOC entry 182 (class 1259 OID 42158)
-- Name: CableLinePoint; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 182
-- Name: TABLE "CableLinePoint"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "CableLinePoint" IS 'Дані про точки кабельної лінії.';


--
-- TOC entry 181 (class 1259 OID 42156)
-- Name: CableLinePoint_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CableLinePoint_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 181
-- Name: CableLinePoint_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CableLinePoint_id_seq" OWNED BY "CableLinePoint".id;


--
-- TOC entry 165 (class 1259 OID 42075)
-- Name: CableLine_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CableLine_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 165
-- Name: CableLine_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CableLine_id_seq" OWNED BY "CableLine".id;


--
-- TOC entry 168 (class 1259 OID 42088)
-- Name: CableType; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 168
-- Name: TABLE "CableType"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "CableType" IS 'Типы кабелей';


--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN "CableType"."tensileStrength"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "CableType"."tensileStrength" IS 'Зазначається у кілоНьютонах';


--
-- TOC entry 167 (class 1259 OID 42086)
-- Name: CableType_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "CableType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 167
-- Name: CableType_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "CableType_id_seq" OWNED BY "CableType".id;


--
-- TOC entry 188 (class 1259 OID 42185)
-- Name: FiberSpliceOrganizer; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "FiberSpliceOrganizer" (
    id integer NOT NULL,
    "FiberSpliceOrganizationType" integer
);


--
-- TOC entry 190 (class 1259 OID 42193)
-- Name: FiberSpliceOrganizerType; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "FiberSpliceOrganizerType" (
    id integer NOT NULL,
    marking character varying(20),
    manufacturer character varying(20),
    note text
);


--
-- TOC entry 189 (class 1259 OID 42191)
-- Name: FiberSpliceOrganizerType_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "FiberSpliceOrganizerType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 189
-- Name: FiberSpliceOrganizerType_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "FiberSpliceOrganizerType_id_seq" OWNED BY "FiberSpliceOrganizerType".id;


--
-- TOC entry 187 (class 1259 OID 42183)
-- Name: FiberSpliceOrganizer_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "FiberSpliceOrganizer_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 187
-- Name: FiberSpliceOrganizer_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "FiberSpliceOrganizer_id_seq" OWNED BY "FiberSpliceOrganizer".id;


--
-- TOC entry 172 (class 1259 OID 42111)
-- Name: IPaddress; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IPaddress" (
    id integer NOT NULL,
    address inet,
    "IPaddressSpace" integer,
    comment text,
    "ParentNetwork" bigint
);


--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN "IPaddress"."ParentNetwork"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "IPaddress"."ParentNetwork" IS 'Належніть до IP мережі';


--
-- TOC entry 174 (class 1259 OID 42123)
-- Name: IPaddressOperator; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IPaddressOperator" (
    id integer NOT NULL,
    name character varying(50),
    "Organization" integer
);


--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 174
-- Name: TABLE "IPaddressOperator"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "IPaddressOperator" IS 'Оператори IP мереж. Створено для збереження відомостей про розподіл адрес операторами, які можуть повторюватися.';


--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 174
-- Name: COLUMN "IPaddressOperator"."Organization"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "IPaddressOperator"."Organization" IS 'Повинно посилатися на таблицю з описом організацій.';


--
-- TOC entry 173 (class 1259 OID 42121)
-- Name: IPaddressOperator_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IPaddressOperator_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 173
-- Name: IPaddressOperator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IPaddressOperator_id_seq" OWNED BY "IPaddressOperator".id;


--
-- TOC entry 176 (class 1259 OID 42131)
-- Name: IPaddressSpace; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "IPaddressSpace" (
    id integer NOT NULL,
    "IPaddressOperator" integer,
    assign character varying(50)
);


--
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 176
-- Name: TABLE "IPaddressSpace"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "IPaddressSpace" IS 'Незалежні IP адресні простори в межах одного оператора, але призначені для забезпечення функціонування роздільних ділянок мереж, в яких можливо повторення IP адрес. Наприклад призначення так званих приватних мереж, однакові адреси яких можуть бути призначені декількам пристроям в обасті контролю оператора.';


--
-- TOC entry 175 (class 1259 OID 42129)
-- Name: IPaddressSpace_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IPaddressSpace_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 175
-- Name: IPaddressSpace_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IPaddressSpace_id_seq" OWNED BY "IPaddressSpace".id;


--
-- TOC entry 171 (class 1259 OID 42109)
-- Name: IPaddress_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "IPaddress_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 171
-- Name: IPaddress_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "IPaddress_id_seq" OWNED BY "IPaddress".id;


--
-- TOC entry 268 (class 1259 OID 53457)
-- Name: LogAdminActions; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 268
-- Name: TABLE "LogAdminActions"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "LogAdminActions" IS 'Операції адміністраторів над записами у БД';


--
-- TOC entry 267 (class 1259 OID 53455)
-- Name: LogAdminActions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "LogAdminActions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3141 (class 0 OID 0)
-- Dependencies: 267
-- Name: LogAdminActions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "LogAdminActions_id_seq" OWNED BY "LogAdminActions".id;


--
-- TOC entry 266 (class 1259 OID 53434)
-- Name: LogTableList; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "LogTableList" (
    id integer NOT NULL,
    name text,
    description text
);


--
-- TOC entry 3142 (class 0 OID 0)
-- Dependencies: 266
-- Name: TABLE "LogTableList"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "LogTableList" IS 'Відповідність ID таблиці в журналі та імені таблиці в БД';


--
-- TOC entry 265 (class 1259 OID 53432)
-- Name: LogTableList_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "LogTableList_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3143 (class 0 OID 0)
-- Dependencies: 265
-- Name: LogTableList_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "LogTableList_id_seq" OWNED BY "LogTableList".id;


--
-- TOC entry 192 (class 1259 OID 42204)
-- Name: NetworkBox; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "NetworkBox" (
    id integer NOT NULL,
    "NetworkBoxType" integer,
    "inventoryNumber" integer
);


--
-- TOC entry 3144 (class 0 OID 0)
-- Dependencies: 192
-- Name: TABLE "NetworkBox"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "NetworkBox" IS 'Для забезпечення можливості збереження даних які стосуються кожного окремого виробу.';


--
-- TOC entry 184 (class 1259 OID 42169)
-- Name: NetworkBoxType; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 183 (class 1259 OID 42167)
-- Name: NetworkBoxType_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "NetworkBoxType_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3145 (class 0 OID 0)
-- Dependencies: 183
-- Name: NetworkBoxType_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "NetworkBoxType_id_seq" OWNED BY "NetworkBoxType".id;


--
-- TOC entry 191 (class 1259 OID 42202)
-- Name: NetworkBox_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "NetworkBox_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3146 (class 0 OID 0)
-- Dependencies: 191
-- Name: NetworkBox_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "NetworkBox_id_seq" OWNED BY "NetworkBox".id;


--
-- TOC entry 178 (class 1259 OID 42139)
-- Name: NetworkNode; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3147 (class 0 OID 0)
-- Dependencies: 178
-- Name: TABLE "NetworkNode"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "NetworkNode" IS 'Узлы сети.';


--
-- TOC entry 3148 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN "NetworkNode"."SettlementGeoSpatial"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "NetworkNode"."SettlementGeoSpatial" IS 'Не потрібно заповнювати, якщо є відомості про будівлю.';


--
-- TOC entry 3149 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN "NetworkNode"."Building"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "NetworkNode"."Building" IS 'Не потрібно заповнювати, якщо є відомості про апартаменти.';


--
-- TOC entry 177 (class 1259 OID 42137)
-- Name: NetworkNode_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "NetworkNode_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3150 (class 0 OID 0)
-- Dependencies: 177
-- Name: NetworkNode_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "NetworkNode_id_seq" OWNED BY "NetworkNode".id;


SET default_with_oids = false;

--
-- TOC entry 272 (class 1259 OID 147885)
-- Name: OpticalFiber; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OpticalFiber" (
    id integer NOT NULL,
    "CableLine" integer NOT NULL,
    fiber integer NOT NULL,
    note text
);


--
-- TOC entry 276 (class 1259 OID 147919)
-- Name: OpticalFiberJoin; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OpticalFiberJoin" (
    id integer NOT NULL,
    "OpticalFiber" integer NOT NULL,
    "OpticalFiberSplice" integer NOT NULL
);


--
-- TOC entry 3151 (class 0 OID 0)
-- Dependencies: 276
-- Name: TABLE "OpticalFiberJoin"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "OpticalFiberJoin" IS 'Таблиця з''єднань оптичних волокон';


--
-- TOC entry 274 (class 1259 OID 147903)
-- Name: OpticalFiberSplice; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "OpticalFiberSplice" (
    id integer NOT NULL,
    "NetworkNode" integer NOT NULL,
    attenuation integer,
    note text,
    "FiberSpliceOrganizer" integer
);


--
-- TOC entry 3152 (class 0 OID 0)
-- Dependencies: 274
-- Name: TABLE "OpticalFiberSplice"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "OpticalFiberSplice" IS 'Оптичні зварювання';


--
-- TOC entry 273 (class 1259 OID 147901)
-- Name: OpticalFiberSplice_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "OpticalFiberSplice_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3153 (class 0 OID 0)
-- Dependencies: 273
-- Name: OpticalFiberSplice_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "OpticalFiberSplice_id_seq" OWNED BY "OpticalFiberSplice".id;


--
-- TOC entry 271 (class 1259 OID 147883)
-- Name: OpticalFiber_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "OpticalFiber_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3154 (class 0 OID 0)
-- Dependencies: 271
-- Name: OpticalFiber_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "OpticalFiber_id_seq" OWNED BY "OpticalFiber".id;


SET default_with_oids = true;

--
-- TOC entry 164 (class 1259 OID 42066)
-- Name: SettlementGeoSite; Type: TABLE; Schema: public; Owner: -
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
-- TOC entry 3155 (class 0 OID 0)
-- Dependencies: 164
-- Name: TABLE "SettlementGeoSite"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "SettlementGeoSite" IS 'Ділянки які наділені поштовою адресою.';


--
-- TOC entry 3156 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN "SettlementGeoSite"."SettlementGeoSpatial"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "SettlementGeoSite"."SettlementGeoSpatial" IS 'Для оптимізації обчислювалних потужностей. В майбутньому можливо визначати за допомогою розрахунків перетинання областей.';


--
-- TOC entry 163 (class 1259 OID 42064)
-- Name: SettlementGeoSite_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "SettlementGeoSite_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3157 (class 0 OID 0)
-- Dependencies: 163
-- Name: SettlementGeoSite_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "SettlementGeoSite_id_seq" OWNED BY "SettlementGeoSite".id;


--
-- TOC entry 170 (class 1259 OID 42100)
-- Name: SettlementGeoSpatial; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "SettlementGeoSpatial" (
    id integer NOT NULL,
    "OpenGIS" polygon,
    name character varying(30),
    "settlementGeoSpatialType" character varying(20)
);


--
-- TOC entry 3158 (class 0 OID 0)
-- Dependencies: 170
-- Name: TABLE "SettlementGeoSpatial"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "SettlementGeoSpatial" IS 'Географічні об’єкти населених пунктів. (улица, площадь, проспект, переулок, бульвар, шоссе, набережная, тупик, проезд, аллея, мост, путепровод, эстакада, парк, сквер, река, озеро, пруд, гора, возвышенность, и др.)';


--
-- TOC entry 180 (class 1259 OID 42150)
-- Name: SettlementGeoSpatialAlias; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE "SettlementGeoSpatialAlias" (
    id integer NOT NULL,
    name character varying(25),
    "SettlementGeoSpatial" bigint NOT NULL
);


--
-- TOC entry 179 (class 1259 OID 42148)
-- Name: SettlementGeoSpatialAlias_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "SettlementGeoSpatialAlias_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3159 (class 0 OID 0)
-- Dependencies: 179
-- Name: SettlementGeoSpatialAlias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "SettlementGeoSpatialAlias_id_seq" OWNED BY "SettlementGeoSpatialAlias".id;


--
-- TOC entry 169 (class 1259 OID 42098)
-- Name: SettlementGeoSpatial_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "SettlementGeoSpatial_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3160 (class 0 OID 0)
-- Dependencies: 169
-- Name: SettlementGeoSpatial_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "SettlementGeoSpatial_id_seq" OWNED BY "SettlementGeoSpatial".id;


--
-- TOC entry 264 (class 1259 OID 45194)
-- Name: Users; Type: TABLE; Schema: public; Owner: -
--

CREATE SEQUENCE "Users_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE "Users" (
    id integer DEFAULT nextval('"Users_id_seq"'::regclass) NOT NULL,
    username character varying(15) NOT NULL,
    password character varying(50) NOT NULL,
    token character varying(50),
    class character varying(1) DEFAULT 2
);
ALTER TABLE ONLY "Users" ALTER COLUMN class SET STORAGE PLAIN;
ALTER SEQUENCE "Users_id_seq" OWNED BY "Users".id;

COPY "Users" (id, username, password, token, class) FROM stdin;
1	test	f5d1278e8109edd94e1e4197e04873b9	a6f1d586356313aab590d6b27b09ef0a	1
\.

--
-- TOC entry 275 (class 1259 OID 147917)
-- Name: opticalFiberJoin_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE "opticalFiberJoin_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3161 (class 0 OID 0)
-- Dependencies: 275
-- Name: opticalFiberJoin_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE "opticalFiberJoin_id_seq" OWNED BY "OpticalFiberJoin".id;


--
-- TOC entry 2999 (class 2604 OID 42057)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Apartment" ALTER COLUMN id SET DEFAULT nextval('"Apartment_id_seq"'::regclass);


--
-- TOC entry 3015 (class 2604 OID 42215)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Building" ALTER COLUMN id SET DEFAULT nextval('"Building_id_seq"'::regclass);


--
-- TOC entry 3001 (class 2604 OID 42080)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLine" ALTER COLUMN id SET DEFAULT nextval('"CableLine_id_seq"'::regclass);


--
-- TOC entry 3010 (class 2604 OID 42161)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint" ALTER COLUMN id SET DEFAULT nextval('"CableLinePoint_id_seq"'::regclass);


--
-- TOC entry 3003 (class 2604 OID 42091)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableType" ALTER COLUMN id SET DEFAULT nextval('"CableType_id_seq"'::regclass);


--
-- TOC entry 3012 (class 2604 OID 42188)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "FiberSpliceOrganizer" ALTER COLUMN id SET DEFAULT nextval('"FiberSpliceOrganizer_id_seq"'::regclass);


--
-- TOC entry 3013 (class 2604 OID 42196)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "FiberSpliceOrganizerType" ALTER COLUMN id SET DEFAULT nextval('"FiberSpliceOrganizerType_id_seq"'::regclass);


--
-- TOC entry 3005 (class 2604 OID 42114)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddress" ALTER COLUMN id SET DEFAULT nextval('"IPaddress_id_seq"'::regclass);


--
-- TOC entry 3006 (class 2604 OID 42126)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddressOperator" ALTER COLUMN id SET DEFAULT nextval('"IPaddressOperator_id_seq"'::regclass);


--
-- TOC entry 3007 (class 2604 OID 42134)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddressSpace" ALTER COLUMN id SET DEFAULT nextval('"IPaddressSpace_id_seq"'::regclass);


--
-- TOC entry 3019 (class 2604 OID 53460)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogAdminActions" ALTER COLUMN id SET DEFAULT nextval('"LogAdminActions_id_seq"'::regclass);


--
-- TOC entry 3018 (class 2604 OID 53437)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogTableList" ALTER COLUMN id SET DEFAULT nextval('"LogTableList_id_seq"'::regclass);


--
-- TOC entry 3014 (class 2604 OID 42207)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBox" ALTER COLUMN id SET DEFAULT nextval('"NetworkBox_id_seq"'::regclass);


--
-- TOC entry 3011 (class 2604 OID 42172)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBoxType" ALTER COLUMN id SET DEFAULT nextval('"NetworkBoxType_id_seq"'::regclass);


--
-- TOC entry 3008 (class 2604 OID 42142)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode" ALTER COLUMN id SET DEFAULT nextval('"NetworkNode_id_seq"'::regclass);


--
-- TOC entry 3020 (class 2604 OID 147888)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiber" ALTER COLUMN id SET DEFAULT nextval('"OpticalFiber_id_seq"'::regclass);


--
-- TOC entry 3022 (class 2604 OID 147922)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberJoin" ALTER COLUMN id SET DEFAULT nextval('"opticalFiberJoin_id_seq"'::regclass);


--
-- TOC entry 3021 (class 2604 OID 147906)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberSplice" ALTER COLUMN id SET DEFAULT nextval('"OpticalFiberSplice_id_seq"'::regclass);


--
-- TOC entry 3000 (class 2604 OID 42069)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSite" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSite_id_seq"'::regclass);


--
-- TOC entry 3004 (class 2604 OID 42103)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSpatial" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSpatial_id_seq"'::regclass);


--
-- TOC entry 3009 (class 2604 OID 42153)
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias" ALTER COLUMN id SET DEFAULT nextval('"SettlementGeoSpatialAlias_id_seq"'::regclass);


--
-- TOC entry 3025 (class 2606 OID 42062)
-- Name: Apartment_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Apartment"
    ADD CONSTRAINT "Apartment_pk" PRIMARY KEY (id);


--
-- TOC entry 3072 (class 2606 OID 42220)
-- Name: Building_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Building"
    ADD CONSTRAINT "Building_pk" PRIMARY KEY (id);


--
-- TOC entry 3053 (class 2606 OID 71530)
-- Name: CableLinePoint_CableLine_NetworkNode_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_NetworkNode_key" UNIQUE ("CableLine", "NetworkNode");


--
-- TOC entry 3055 (class 2606 OID 71532)
-- Name: CableLinePoint_CableLine_meterSign_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_meterSign_key" UNIQUE ("CableLine", "meterSign");


--
-- TOC entry 3058 (class 2606 OID 42166)
-- Name: CableLinePoint_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_pk" PRIMARY KEY (id);


--
-- TOC entry 3029 (class 2606 OID 71528)
-- Name: CableLine_name_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_name_key" UNIQUE (name);


--
-- TOC entry 3031 (class 2606 OID 42085)
-- Name: CableLine_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_pkey" PRIMARY KEY (id);


--
-- TOC entry 3034 (class 2606 OID 42096)
-- Name: CableType_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableType"
    ADD CONSTRAINT "CableType_pkey" PRIMARY KEY (id);


--
-- TOC entry 3066 (class 2606 OID 42201)
-- Name: FiberSpliceOrganizerType_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "FiberSpliceOrganizerType"
    ADD CONSTRAINT "FiberSpliceOrganizerType_pk" PRIMARY KEY (id);


--
-- TOC entry 3064 (class 2606 OID 42190)
-- Name: FiberSpliceOrganizer_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "FiberSpliceOrganizer"
    ADD CONSTRAINT "FiberSpliceOrganizer_pk" PRIMARY KEY (id);


--
-- TOC entry 3043 (class 2606 OID 42136)
-- Name: IPaddressSpace_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddressSpace"
    ADD CONSTRAINT "IPaddressSpace_pkey" PRIMARY KEY (id);


--
-- TOC entry 3039 (class 2606 OID 42119)
-- Name: IPaddress_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddress"
    ADD CONSTRAINT "IPaddress_pkey" PRIMARY KEY (id);


--
-- TOC entry 3041 (class 2606 OID 42128)
-- Name: IPoperator_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddressOperator"
    ADD CONSTRAINT "IPoperator_pkey" PRIMARY KEY (id);


--
-- TOC entry 3079 (class 2606 OID 53465)
-- Name: LogAdminActions_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_pk" PRIMARY KEY (id);


--
-- TOC entry 3077 (class 2606 OID 53442)
-- Name: LogTableList_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogTableList"
    ADD CONSTRAINT "LogTableList_pk" PRIMARY KEY (id);


--
-- TOC entry 3060 (class 2606 OID 71522)
-- Name: NetworkBoxType_marking_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBoxType"
    ADD CONSTRAINT "NetworkBoxType_marking_key" UNIQUE (marking);


--
-- TOC entry 3062 (class 2606 OID 42174)
-- Name: NetworkBoxType_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBoxType"
    ADD CONSTRAINT "NetworkBoxType_pk" PRIMARY KEY (id);


--
-- TOC entry 3068 (class 2606 OID 71520)
-- Name: NetworkBox_inventoryNumber_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_inventoryNumber_key" UNIQUE ("inventoryNumber");


--
-- TOC entry 3070 (class 2606 OID 42209)
-- Name: NetworkBox_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_pk" PRIMARY KEY (id);


--
-- TOC entry 3045 (class 2606 OID 71526)
-- Name: NetworkNode_NetworkBox_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_NetworkBox_key" UNIQUE ("NetworkBox");


--
-- TOC entry 3047 (class 2606 OID 71524)
-- Name: NetworkNode_name_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_name_key" UNIQUE (name);


--
-- TOC entry 3049 (class 2606 OID 42147)
-- Name: NetworkNode_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_pkey" PRIMARY KEY (id);


--
-- TOC entry 3084 (class 2606 OID 147911)
-- Name: OpticalFiberSplice_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_pkey" PRIMARY KEY (id);


--
-- TOC entry 3082 (class 2606 OID 147893)
-- Name: OpticalFiber_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiber"
    ADD CONSTRAINT "OpticalFiber_pkey" PRIMARY KEY (id);


--
-- TOC entry 3027 (class 2606 OID 42074)
-- Name: SettlementGeoSite_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSite"
    ADD CONSTRAINT "SettlementGeoSite_pk" PRIMARY KEY (id);


--
-- TOC entry 3051 (class 2606 OID 42155)
-- Name: SettlementGeoSpatialAlias_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias"
    ADD CONSTRAINT "SettlementGeoSpatialAlias_pk" PRIMARY KEY (id);


--
-- TOC entry 3036 (class 2606 OID 42108)
-- Name: SettlementGeoSpatial_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSpatial"
    ADD CONSTRAINT "SettlementGeoSpatial_pk" PRIMARY KEY (id);


--
-- TOC entry 3074 (class 2606 OID 53472)
-- Name: Users_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_pk" PRIMARY KEY (id);


--
-- TOC entry 3086 (class 2606 OID 147926)
-- Name: opticalFiberJoin_OpticalFiber_OpticalFiberSplice_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiber_OpticalFiberSplice_key" UNIQUE ("OpticalFiber", "OpticalFiberSplice");


--
-- TOC entry 3088 (class 2606 OID 147924)
-- Name: opticalFiberJoin_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_pkey" PRIMARY KEY (id);


--
-- TOC entry 3023 (class 1259 OID 42063)
-- Name: Address_apartment_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "Address_apartment_key" ON "Apartment" USING btree (name, other);


--
-- TOC entry 3056 (class 1259 OID 143638)
-- Name: CableLinePoint_CableLine_sequence; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "CableLinePoint_CableLine_sequence" ON "CableLinePoint" USING btree ("CableLine", sequence);


--
-- TOC entry 3032 (class 1259 OID 42097)
-- Name: CableType_marking_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "CableType_marking_key" ON "CableType" USING btree (marking);


--
-- TOC entry 3037 (class 1259 OID 42120)
-- Name: IPaddress_address_key; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IPaddress_address_key" ON "IPaddress" USING btree (address);


--
-- TOC entry 3075 (class 1259 OID 53443)
-- Name: LogTableList_name; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "LogTableList_name" ON "LogTableList" USING btree (name);


--
-- TOC entry 3080 (class 1259 OID 147900)
-- Name: OpticalFiber_CableLine_fiber; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "OpticalFiber_CableLine_fiber" ON "OpticalFiber" USING btree ("CableLine", fiber);


--
-- TOC entry 3089 (class 2606 OID 42286)
-- Name: Apartment_Building_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Apartment"
    ADD CONSTRAINT "Apartment_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3106 (class 2606 OID 42281)
-- Name: Building_SettlementGeoSite_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "Building"
    ADD CONSTRAINT "Building_SettlementGeoSite_fkey" FOREIGN KEY ("SettlementGeoSite") REFERENCES "SettlementGeoSite"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3103 (class 2606 OID 42321)
-- Name: CableLinePoint_Apartment_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3102 (class 2606 OID 42316)
-- Name: CableLinePoint_Building_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3099 (class 2606 OID 42231)
-- Name: CableLinePoint_CableLine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_CableLine_fkey" FOREIGN KEY ("CableLine") REFERENCES "CableLine"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3100 (class 2606 OID 42276)
-- Name: CableLinePoint_NetworkNode_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_NetworkNode_fkey" FOREIGN KEY ("NetworkNode") REFERENCES "NetworkNode"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3101 (class 2606 OID 42311)
-- Name: CableLinePoint_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLinePoint"
    ADD CONSTRAINT "CableLinePoint_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3091 (class 2606 OID 42226)
-- Name: CableLine_CableType_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "CableLine"
    ADD CONSTRAINT "CableLine_CableType_fkey" FOREIGN KEY ("CableType") REFERENCES "CableType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3104 (class 2606 OID 42251)
-- Name: FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "FiberSpliceOrganizer"
    ADD CONSTRAINT "FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey" FOREIGN KEY ("FiberSpliceOrganizationType") REFERENCES "FiberSpliceOrganizerType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3093 (class 2606 OID 42221)
-- Name: IPaddressSpace_IPaddressOperator_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddressSpace"
    ADD CONSTRAINT "IPaddressSpace_IPaddressOperator_fkey" FOREIGN KEY ("IPaddressOperator") REFERENCES "IPaddressOperator"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3092 (class 2606 OID 42271)
-- Name: IPaddress_IPaddressSpace_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "IPaddress"
    ADD CONSTRAINT "IPaddress_IPaddressSpace_fkey" FOREIGN KEY ("IPaddressSpace") REFERENCES "IPaddressSpace"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3108 (class 2606 OID 53473)
-- Name: LogAdminActions_admin_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_admin_fk" FOREIGN KEY (admin) REFERENCES "Users"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3107 (class 2606 OID 53466)
-- Name: LogAdminActions_table_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "LogAdminActions"
    ADD CONSTRAINT "LogAdminActions_table_fk" FOREIGN KEY ("table") REFERENCES "LogTableList"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3105 (class 2606 OID 42266)
-- Name: NetworkBox_NetworkBoxType_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkBox"
    ADD CONSTRAINT "NetworkBox_NetworkBoxType_fkey" FOREIGN KEY ("NetworkBoxType") REFERENCES "NetworkBoxType"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3096 (class 2606 OID 42301)
-- Name: NetworkNode_Apartment_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3095 (class 2606 OID 42296)
-- Name: NetworkNode_Building_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3094 (class 2606 OID 42261)
-- Name: NetworkNode_NetworkBox_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_NetworkBox_fkey" FOREIGN KEY ("NetworkBox") REFERENCES "NetworkBox"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3097 (class 2606 OID 42306)
-- Name: NetworkNode_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "NetworkNode"
    ADD CONSTRAINT "NetworkNode_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3111 (class 2606 OID 147937)
-- Name: OpticalFiberSplice_FiberSpliceOrganizer_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_FiberSpliceOrganizer_fkey" FOREIGN KEY ("FiberSpliceOrganizer") REFERENCES "FiberSpliceOrganizer"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3110 (class 2606 OID 147912)
-- Name: OpticalFiberSplice_NetworkNode_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberSplice"
    ADD CONSTRAINT "OpticalFiberSplice_NetworkNode_fkey" FOREIGN KEY ("NetworkNode") REFERENCES "NetworkNode"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3109 (class 2606 OID 147895)
-- Name: OpticalFiber_CableLine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiber"
    ADD CONSTRAINT "OpticalFiber_CableLine_fkey" FOREIGN KEY ("CableLine") REFERENCES "CableLine"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3090 (class 2606 OID 42291)
-- Name: SettlementGeoSite_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSite"
    ADD CONSTRAINT "SettlementGeoSite_fkey1" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3098 (class 2606 OID 42256)
-- Name: SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "SettlementGeoSpatialAlias"
    ADD CONSTRAINT "SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3113 (class 2606 OID 147932)
-- Name: opticalFiberJoin_OpticalFiberSplice_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiberSplice_fkey" FOREIGN KEY ("OpticalFiberSplice") REFERENCES "OpticalFiberSplice"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3112 (class 2606 OID 147927)
-- Name: opticalFiberJoin_OpticalFiber_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "OpticalFiberJoin"
    ADD CONSTRAINT "opticalFiberJoin_OpticalFiber_fkey" FOREIGN KEY ("OpticalFiber") REFERENCES "OpticalFiber"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


-- Completed on 2013-01-17 16:46:25 EET

--
-- PostgreSQL database dump complete
--

