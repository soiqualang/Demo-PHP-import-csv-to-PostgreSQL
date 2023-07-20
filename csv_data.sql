-- Adminer 4.8.1 PostgreSQL 13.3 (Debian 13.3-1.pgdg110+1) dump

DROP TABLE IF EXISTS "csv_data";
DROP SEQUENCE IF EXISTS csv_data_id_seq;
CREATE SEQUENCE csv_data_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 16 CACHE 1;

CREATE TABLE "public"."csv_data" (
    "id" integer DEFAULT nextval('csv_data_id_seq') NOT NULL,
    "name" character varying(255),
    "email" character varying(255),
    "age" integer,
    CONSTRAINT "csv_data_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2023-07-20 04:09:29.858844+00
