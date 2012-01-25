------------------------------
-- pgDesigner 1.2.17
--
-- Project    : stream
-- Date       : 01/24/2012 18:23:06.642
-- Description: 
------------------------------


-- Start Table's declaration
DROP TABLE IF EXISTS "Apartment" CASCADE;
CREATE TABLE "Apartment" (
"id" serial NOT NULL,
"OpenGIS" point,
"number" character varying(6),
"name" text,
"Building" integer,
"other" text
) WITH OIDS;
ALTER TABLE "Apartment" ADD CONSTRAINT "Apartment_pk" PRIMARY KEY("id");
COMMENT ON TABLE "Apartment" IS 'Адреса.';
COMMENT ON COLUMN "Apartment"."name" IS 'Номер назва кімнати (машинна кімната ліфту, кімната на техповерсі та т.і.)';
COMMENT ON COLUMN "Apartment"."other" IS 'номер подъезда, название заведения, и т.д.';
CREATE UNIQUE INDEX "Address_apartment_key" ON "Apartment" USING btree ("name","other");

DROP TABLE IF EXISTS "SettlementGeoSite" CASCADE;
CREATE TABLE "SettlementGeoSite" (
"id" serial NOT NULL,
"OpenGIS" polygon,
"number" character varying(5),
"corps" integer,
"SettlementGeoSpatial" integer,
"note" text
) WITH OIDS;
ALTER TABLE "SettlementGeoSite" ADD CONSTRAINT "SettlementGeoSite_pk" PRIMARY KEY("id");
COMMENT ON TABLE "SettlementGeoSite" IS 'Ділянки які наділені поштовою адресою.';
COMMENT ON COLUMN "SettlementGeoSite"."SettlementGeoSpatial" IS 'Для оптимізації обчислювалних потужностей. В майбутньому можливо визначати за допомогою розрахунків перетинання областей.';

DROP TABLE IF EXISTS "CableLine" CASCADE;
CREATE TABLE "CableLine" (
"id" serial NOT NULL,
"OpenGIS" path,
"CableType" integer,
"length" integer,
"comment" text
) WITH OIDS;
ALTER TABLE "CableLine" ADD CONSTRAINT "CableLine_pkey" PRIMARY KEY("id");
COMMENT ON TABLE "CableLine" IS 'Кабельные линии.';
COMMENT ON COLUMN "CableLine"."length" IS 'Тимчасове поле. В подальшому буде вираховуватися.';

DROP TABLE IF EXISTS "CableType" CASCADE;
CREATE TABLE "CableType" (
"id" serial NOT NULL,
"marking" character varying(30),
"manufacturer" character varying(30),
"tubeQuantity" int,
"fiberPerTube" int,
"tensileStrength" int,
"diameter" int,
"comment" text
) WITH OIDS;
ALTER TABLE "CableType" ADD CONSTRAINT "CableType_pkey" PRIMARY KEY("id");
COMMENT ON TABLE "CableType" IS 'Типы кабелей';
COMMENT ON COLUMN "CableType"."tensileStrength" IS 'Зазначається у кілоНьютонах';
CREATE UNIQUE INDEX "CableType_marking_key" ON "CableType" USING btree ("marking");

DROP TABLE IF EXISTS "SettlementGeoSpatial" CASCADE;
CREATE TABLE "SettlementGeoSpatial" (
"id" serial NOT NULL,
"OpenGIS" polygon,
"name" character varying(30),
"settlementGeoSpatialType" character varying(20)
) WITH OIDS;
ALTER TABLE "SettlementGeoSpatial" ADD CONSTRAINT "SettlementGeoSpatial_pk" PRIMARY KEY("id");
COMMENT ON TABLE "SettlementGeoSpatial" IS 'Географічні об’єкти населених пунктів. (улица, площадь, проспект, переулок, бульвар, шоссе, набережная, тупик, проезд, аллея, мост, путепровод, эстакада, парк, сквер, река, озеро, пруд, гора, возвышенность, и др.)';

DROP TABLE IF EXISTS "IPaddress" CASCADE;
CREATE TABLE "IPaddress" (
"id" serial NOT NULL,
"address" inet,
"IPaddressSpace" integer,
"comment" text,
"ParentNetwork" bigint
) WITH OIDS;
ALTER TABLE "IPaddress" ADD CONSTRAINT "IPaddress_pkey" PRIMARY KEY("id");
COMMENT ON COLUMN "IPaddress"."ParentNetwork" IS 'Належніть до IP мережі';
CREATE UNIQUE INDEX "IPaddress_address_key" ON "IPaddress" USING btree ("address");

DROP TABLE IF EXISTS "IPaddressOperator" CASCADE;
CREATE TABLE "IPaddressOperator" (
"id" serial NOT NULL,
"name" character varying(50),
"Organization" integer
) WITH OIDS;
ALTER TABLE "IPaddressOperator" ADD CONSTRAINT "IPoperator_pkey" PRIMARY KEY("id");
COMMENT ON TABLE "IPaddressOperator" IS 'Оператори IP мереж. Створено для збереження відомостей про розподіл адрес операторами, які можуть повторюватися.';
COMMENT ON COLUMN "IPaddressOperator"."Organization" IS 'Повинно посилатися на таблицю з описом організацій.';

DROP TABLE IF EXISTS "IPaddressSpace" CASCADE;
CREATE TABLE "IPaddressSpace" (
"id" serial NOT NULL,
"IPaddressOperator" integer,
"assign" character varying(50)
) WITH OIDS;
ALTER TABLE "IPaddressSpace" ADD CONSTRAINT "IPaddressSpace_pkey" PRIMARY KEY("id");
COMMENT ON TABLE "IPaddressSpace" IS 'Незалежні IP адресні простори в межах одного оператора, але призначені для забезпечення функціонування роздільних ділянок мереж, в яких можливо повторення IP адрес. Наприклад призначення так званих приватних мереж, однакові адреси яких можуть бути призначені декількам пристроям в обасті контролю оператора.';

DROP TABLE IF EXISTS "NetworkNode" CASCADE;
CREATE TABLE "NetworkNode" (
"id" serial NOT NULL,
"OpenGIS" point,
"name" name NOT NULL,
"NetworkBox" integer,
"note" text,
"SettlementGeoSpatial" integer,
"Building" integer,
"Apartment" integer
) WITH OIDS;
ALTER TABLE "NetworkNode" ADD CONSTRAINT "NetworkNode_pkey" PRIMARY KEY("id");
COMMENT ON TABLE "NetworkNode" IS 'Узлы сети.';
COMMENT ON COLUMN "NetworkNode"."SettlementGeoSpatial" IS 'Не потрібно заповнювати, якщо є відомості про будівлю.';
COMMENT ON COLUMN "NetworkNode"."Building" IS 'Не потрібно заповнювати, якщо є відомості про апартаменти.';

DROP TABLE IF EXISTS "SettlementGeoSpatialAlias" CASCADE;
CREATE TABLE "SettlementGeoSpatialAlias" (
"id" serial NOT NULL,
"name" character varying(25),
"SettlementGeoSpatial" bigint NOT NULL
) WITH OIDS;
ALTER TABLE "SettlementGeoSpatialAlias" ADD CONSTRAINT "SettlementGeoSpatialAlias_pk" PRIMARY KEY("id");

DROP TABLE IF EXISTS "CableLinePoint" CASCADE;
CREATE TABLE "CableLinePoint" (
"id" serial NOT NULL,
"OpenGIS" point,
"CableLine" integer,
"meterSign" int,
"NetworkNode" integer,
"note" text,
"Apartment" integer,
"Building" integer,
"SettlementGeoSpatial" integer
) WITH OIDS;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_pk" PRIMARY KEY("id");
COMMENT ON TABLE "CableLinePoint" IS 'Дані про точки кабельної лінії.';

DROP TABLE IF EXISTS "NetworkBoxType" CASCADE;
CREATE TABLE "NetworkBoxType" (
"id" serial NOT NULL,
"marking" character varying(20),
"manufacturer" character varying(30),
"units" int,
"width" int,
"height" int,
"length" int,
"diameter" int
) WITH OIDS;
ALTER TABLE "NetworkBoxType" ADD CONSTRAINT "NetworkBoxType_pk" PRIMARY KEY("id");

DROP TABLE IF EXISTS "FiberSplice" CASCADE;
CREATE TABLE "FiberSplice" (
"id" serial NOT NULL,
"CableLinePointA" integer NOT NULL,
"fiberA" int NOT NULL,
"CableLinePointB" integer NOT NULL,
"fiberB" integer NOT NULL,
"FiberSpliceOrganizer" integer
) WITH OIDS;
ALTER TABLE "FiberSplice" ADD CONSTRAINT "FiberSplice_pk" PRIMARY KEY("id");

DROP TABLE IF EXISTS "FiberSpliceOrganizer" CASCADE;
CREATE TABLE "FiberSpliceOrganizer" (
"id" serial NOT NULL,
"FiberSpliceOrganizationType" integer
) WITH OIDS;
ALTER TABLE "FiberSpliceOrganizer" ADD CONSTRAINT "FiberSpliceOrganizer_pk" PRIMARY KEY("id");

DROP TABLE IF EXISTS "FiberSpliceOrganizerType" CASCADE;
CREATE TABLE "FiberSpliceOrganizerType" (
"id" serial NOT NULL,
"marking" character varying(20),
"manufacturer" character varying(20),
"note" text
) WITH OIDS;
ALTER TABLE "FiberSpliceOrganizerType" ADD CONSTRAINT "FiberSpliceOrganizerType_pk" PRIMARY KEY("id");

DROP TABLE IF EXISTS "NetworkBox" CASCADE;
CREATE TABLE "NetworkBox" (
"id" serial NOT NULL,
"NetworkBoxType" integer,
"inventoryNumber" integer
) WITH OIDS;
ALTER TABLE "NetworkBox" ADD CONSTRAINT "NetworkBox_pk" PRIMARY KEY("id");
COMMENT ON TABLE "NetworkBox" IS 'Для забезпечення можливості збереження даних які стосуються кожного окремого виробу.';

DROP TABLE IF EXISTS "Building" CASCADE;
CREATE TABLE "Building" (
"id" serial NOT NULL,
"OpenGIS" polygon,
"SettlementGeoSite" integer,
"BuildingType" integer
) WITH OIDS;
ALTER TABLE "Building" ADD CONSTRAINT "Building_pk" PRIMARY KEY("id");

-- End Table's declaration

-- Start Relation's declaration
ALTER TABLE "IPaddressSpace" DROP CONSTRAINT "IPaddressSpace_IPaddressOperator_fkey" CASCADE;
ALTER TABLE "IPaddressSpace" ADD CONSTRAINT "IPaddressSpace_IPaddressOperator_fkey" FOREIGN KEY ("IPaddressOperator") REFERENCES "IPaddressOperator"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLine" DROP CONSTRAINT "CableLine_CableType_fkey" CASCADE;
ALTER TABLE "CableLine" ADD CONSTRAINT "CableLine_CableType_fkey" FOREIGN KEY ("CableType") REFERENCES "CableType"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLinePoint" DROP CONSTRAINT "CableLinePoint_CableLine_fkey" CASCADE;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_CableLine_fkey" FOREIGN KEY ("CableLine") REFERENCES "CableLine"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "FiberSplice" DROP CONSTRAINT "FiberSplice_CableLinePointA_fkey" CASCADE;
ALTER TABLE "FiberSplice" ADD CONSTRAINT "FiberSplice_CableLinePointA_fkey" FOREIGN KEY ("CableLinePointA") REFERENCES "CableLinePoint"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "FiberSplice" DROP CONSTRAINT "FiberSplice_CableLinePointB_fkey" CASCADE;
ALTER TABLE "FiberSplice" ADD CONSTRAINT "FiberSplice_CableLinePointB_fkey" FOREIGN KEY ("CableLinePointB") REFERENCES "CableLinePoint"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "FiberSplice" DROP CONSTRAINT "FiberSplice_FiberSpliceOrganizer_fkey" CASCADE;
ALTER TABLE "FiberSplice" ADD CONSTRAINT "FiberSplice_FiberSpliceOrganizer_fkey" FOREIGN KEY ("FiberSpliceOrganizer") REFERENCES "FiberSpliceOrganizer"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "FiberSpliceOrganizer" DROP CONSTRAINT "FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey" CASCADE;
ALTER TABLE "FiberSpliceOrganizer" ADD CONSTRAINT "FiberSpliceOrganizer_FiberSpliceOrganizerType_fkey" FOREIGN KEY ("FiberSpliceOrganizationType") REFERENCES "FiberSpliceOrganizerType"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "SettlementGeoSpatialAlias" DROP CONSTRAINT "SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey" CASCADE;
ALTER TABLE "SettlementGeoSpatialAlias" ADD CONSTRAINT "SettlementGeoSpatialAlias_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "NetworkNode" DROP CONSTRAINT "NetworkNode_NetworkBox_fkey" CASCADE;
ALTER TABLE "NetworkNode" ADD CONSTRAINT "NetworkNode_NetworkBox_fkey" FOREIGN KEY ("NetworkBox") REFERENCES "NetworkBox"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "NetworkBox" DROP CONSTRAINT "NetworkBox_NetworkBoxType_fkey" CASCADE;
ALTER TABLE "NetworkBox" ADD CONSTRAINT "NetworkBox_NetworkBoxType_fkey" FOREIGN KEY ("NetworkBoxType") REFERENCES "NetworkBoxType"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "IPaddress" DROP CONSTRAINT "IPaddress_IPaddressSpace_fkey" CASCADE;
ALTER TABLE "IPaddress" ADD CONSTRAINT "IPaddress_IPaddressSpace_fkey" FOREIGN KEY ("IPaddressSpace") REFERENCES "IPaddressSpace"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLinePoint" DROP CONSTRAINT "CableLinePoint_NetworkNode_fkey" CASCADE;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_NetworkNode_fkey" FOREIGN KEY ("NetworkNode") REFERENCES "NetworkNode"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "Building" DROP CONSTRAINT "Building_SettlementGeoSite_fkey" CASCADE;
ALTER TABLE "Building" ADD CONSTRAINT "Building_SettlementGeoSite_fkey" FOREIGN KEY ("SettlementGeoSite") REFERENCES "SettlementGeoSite"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "Apartment" DROP CONSTRAINT "Apartment_Building_fkey" CASCADE;
ALTER TABLE "Apartment" ADD CONSTRAINT "Apartment_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "SettlementGeoSite" DROP CONSTRAINT "SettlementGeoSite_fkey1" CASCADE;
ALTER TABLE "SettlementGeoSite" ADD CONSTRAINT "SettlementGeoSite_fkey1" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "NetworkNode" DROP CONSTRAINT "NetworkNode_Building_fkey" CASCADE;
ALTER TABLE "NetworkNode" ADD CONSTRAINT "NetworkNode_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "NetworkNode" DROP CONSTRAINT "NetworkNode_Apartment_fkey" CASCADE;
ALTER TABLE "NetworkNode" ADD CONSTRAINT "NetworkNode_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "NetworkNode" DROP CONSTRAINT "NetworkNode_SettlementGeoSpatial_fkey" CASCADE;
ALTER TABLE "NetworkNode" ADD CONSTRAINT "NetworkNode_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLinePoint" DROP CONSTRAINT "CableLinePoint_SettlementGeoSpatial_fkey" CASCADE;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_SettlementGeoSpatial_fkey" FOREIGN KEY ("SettlementGeoSpatial") REFERENCES "SettlementGeoSpatial"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLinePoint" DROP CONSTRAINT "CableLinePoint_Building_fkey" CASCADE;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_Building_fkey" FOREIGN KEY ("Building") REFERENCES "Building"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "CableLinePoint" DROP CONSTRAINT "CableLinePoint_Apartment_fkey" CASCADE;
ALTER TABLE "CableLinePoint" ADD CONSTRAINT "CableLinePoint_Apartment_fkey" FOREIGN KEY ("Apartment") REFERENCES "Apartment"("id") ON UPDATE CASCADE ON DELETE RESTRICT;

-- End Relation's declaration

