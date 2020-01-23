--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: drop_cargo(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_cargo(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos cargo%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_cargo FROM cargo WHERE codigo_cargo=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM cargo Where codigo_cargo=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_cargo(integer) OWNER TO dimas;

--
-- Name: drop_centro_votacion(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_centro_votacion(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos centro_votacion%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_centro FROM centro_votacion WHERE codigo_centro=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM centro_votacion Where codigo_centro=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_centro_votacion(integer) OWNER TO dimas;

--
-- Name: drop_contactado(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_contactado(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos contactado%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_militante FROM contactado WHERE cedula_militante=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM contactado Where cedula_militante=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_contactado(character varying) OWNER TO dimas;

--
-- Name: drop_inbox(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_inbox(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos inbox%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos ID FROM inbox WHERE ID=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM inbox Where ID=$1;

      RETURN 1;    

   END IF;  	

end

$_$;


ALTER FUNCTION public.drop_inbox(integer) OWNER TO dimas;

--
-- Name: drop_militante(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_militante(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos militantes%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_militante FROM militantes WHERE cedula_militante=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM militantes Where cedula_militante=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_militante(character varying) OWNER TO dimas;

--
-- Name: drop_parroquia(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_parroquia(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos parroquia%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_parroquia FROM parroquia WHERE codigo_parroquia=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM parroquia Where codigo_parroquia=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_parroquia(integer) OWNER TO dimas;

--
-- Name: drop_usuario(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION drop_usuario(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula FROM usuarios WHERE cedula=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM usuarios Where cedula=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_usuario(integer) OWNER TO dimas;

--
-- Name: insert_centro_votacion(integer, integer, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION insert_centro_votacion(integer, integer, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos centro_votacion%ROWTYPE;

BEGIN 

   SELECT INTO datos codigo_centro FROM centro_votacion WHERE codigo_centro=$1;

   IF NOT FOUND THEN

     INSERT INTO centro_votacion values($1,$2,$3,$4,$5); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_centro_votacion(integer, integer, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: insert_outbox(character varying, text, text); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION insert_outbox(character varying, text, text) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos outbox%ROWTYPE;

BEGIN 

     INSERT INTO outbox("DestinationNumber", "TextDecoded", "CreatorID") values($1,$2,$3); 

     RETURN 1;

end$_$;


ALTER FUNCTION public.insert_outbox(character varying, text, text) OWNER TO dimas;

--
-- Name: insert_usuario(integer, character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION insert_usuario(integer, character varying, character varying, character varying, character varying, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula FROM usuarios WHERE cedula=$1;

   IF NOT FOUND THEN

     INSERT INTO usuarios values($1,$2,$3,$4,$5,$6,$7); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_usuario(integer, character varying, character varying, character varying, character varying, integer, integer) OWNER TO dimas;

--
-- Name: unlock_usuario(integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION unlock_usuario(integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula FROM usuarios WHERE cedula=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET status=$2 WHERE cedula=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.unlock_usuario(integer, integer) OWNER TO dimas;

--
-- Name: update_cargo(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_cargo(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos cargo%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_cargo FROM cargo WHERE codigo_cargo=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE cargo SET nombre_cargo=$2 WHERE codigo_cargo=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_cargo(integer, character varying) OWNER TO dimas;

--
-- Name: update_centro_votacion(integer, integer, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_centro_votacion(integer, integer, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos centro_votacion%ROWTYPE;

BEGIN 

  SELECT INTO datos codigo_centro FROM centro_votacion WHERE codigo_centro=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE centro_votacion SET codigo_parroquia=$2, nombre_centro=$3, direccion_centro=$4, n_eje=$5 WHERE codigo_centro=$1;

      RETURN 1;    

   END IF;

end	$_$;


ALTER FUNCTION public.update_centro_votacion(integer, integer, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: update_militante(character varying, integer, integer, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_militante(character varying, integer, integer, character varying, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos militantes%ROWTYPE;

BEGIN 

  SELECT INTO datos cedula_militante FROM militantes WHERE cedula_militante=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE militantes SET codigo_cargo=$2, codigo_centro=$3, nombre_militante=$4, apellido_militante=$5, telefono_militante=$6, foto=$7 WHERE cedula_militante=$1;

      RETURN 1;    

   END IF;

end$_$;


ALTER FUNCTION public.update_militante(character varying, integer, integer, character varying, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: update_parroquia(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_parroquia(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos parroquia%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_parroquia FROM parroquia WHERE codigo_parroquia=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE parroquia SET nombre_parroquia=$2 WHERE codigo_parroquia=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_parroquia(integer, character varying) OWNER TO dimas;

--
-- Name: update_timestamp(); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_timestamp() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

  BEGIN

    NEW."UpdatedInDB" := LOCALTIMESTAMP(0);

    RETURN NEW;

  END;

$$;


ALTER FUNCTION public.update_timestamp() OWNER TO dimas;

--
-- Name: update_usuario(integer, character varying, character varying, character varying, character varying, integer, integer, date, time without time zone); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION update_usuario(integer, character varying, character varying, character varying, character varying, integer, integer, date, time without time zone) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos usuarios%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula FROM usuarios WHERE cedula=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET nombre_usuario=$2, apellido_usuario=$3, usuario=$4, pass=$5, nivel_acceso=$6, status=$7, fecha_registro=$8, hora_registro=$9 WHERE cedula=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_usuario(integer, character varying, character varying, character varying, character varying, integer, integer, date, time without time zone) OWNER TO dimas;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: cargo; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE cargo (
    codigo_cargo integer NOT NULL,
    nombre_cargo character varying NOT NULL
);


ALTER TABLE cargo OWNER TO dimas;

--
-- Name: TABLE cargo; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE cargo IS 'tabla de almacenamiento de cargos.';


--
-- Name: cargo_codigo_cargo_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE cargo_codigo_cargo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cargo_codigo_cargo_seq OWNER TO dimas;

--
-- Name: cargo_codigo_cargo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE cargo_codigo_cargo_seq OWNED BY cargo.codigo_cargo;


--
-- Name: centro_votacion; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE centro_votacion (
    codigo_centro integer NOT NULL,
    codigo_parroquia integer NOT NULL,
    nombre_centro character varying NOT NULL,
    direccion_centro character varying NOT NULL,
    n_eje character varying NOT NULL,
    sector character varying
);


ALTER TABLE centro_votacion OWNER TO dimas;

--
-- Name: TABLE centro_votacion; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE centro_votacion IS 'tabla de almacenamiento de los centros de votacion';


--
-- Name: gammu; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE gammu (
    "Version" smallint DEFAULT (0)::smallint NOT NULL
);


ALTER TABLE gammu OWNER TO dimas;

--
-- Name: inbox; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE inbox (
    "UpdatedInDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "ReceivingDateTime" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Text" text NOT NULL,
    "SenderNumber" character varying(20) DEFAULT ''::character varying NOT NULL,
    "Coding" character varying(255) DEFAULT 'Default_No_Compression'::character varying NOT NULL,
    "UDH" text NOT NULL,
    "SMSCNumber" character varying(20) DEFAULT ''::character varying NOT NULL,
    "Class" integer DEFAULT (-1) NOT NULL,
    "TextDecoded" text DEFAULT ''::text NOT NULL,
    "ID" integer NOT NULL,
    "RecipientID" text NOT NULL,
    "Processed" boolean DEFAULT false NOT NULL,
    CONSTRAINT "inbox_Coding_check" CHECK ((("Coding")::text = ANY (ARRAY[('Default_No_Compression'::character varying)::text, ('Unicode_No_Compression'::character varying)::text, ('8bit'::character varying)::text, ('Default_Compression'::character varying)::text, ('Unicode_Compression'::character varying)::text])))
);


ALTER TABLE inbox OWNER TO dimas;

--
-- Name: inbox_ID_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE "inbox_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "inbox_ID_seq" OWNER TO dimas;

--
-- Name: inbox_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE "inbox_ID_seq" OWNED BY inbox."ID";


--
-- Name: militantes; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE militantes (
    cedula_militante character varying NOT NULL,
    codigo_cargo integer NOT NULL,
    codigo_parroquia integer,
    codigo_centro integer,
    nombre_militante character varying,
    apellido_militante character varying,
    telefono_militante character varying,
    foto character varying(30)
);


ALTER TABLE militantes OWNER TO dimas;

--
-- Name: TABLE militantes; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE militantes IS 'tabla de almacenamiento de militantes activos.';


--
-- Name: outbox; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE outbox (
    "UpdatedInDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "InsertIntoDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "SendingDateTime" timestamp without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "SendBefore" time without time zone DEFAULT '23:59:59'::time without time zone NOT NULL,
    "SendAfter" time without time zone DEFAULT '00:00:00'::time without time zone NOT NULL,
    "Text" text,
    "DestinationNumber" character varying(20) DEFAULT ''::character varying NOT NULL,
    "Coding" character varying(255) DEFAULT 'Default_No_Compression'::character varying NOT NULL,
    "UDH" text,
    "Class" integer DEFAULT (-1),
    "TextDecoded" text DEFAULT ''::text NOT NULL,
    "ID" integer NOT NULL,
    "MultiPart" boolean DEFAULT false NOT NULL,
    "RelativeValidity" integer DEFAULT (-1),
    "SenderID" character varying(255),
    "SendingTimeOut" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "DeliveryReport" character varying(10) DEFAULT 'default'::character varying,
    "CreatorID" text NOT NULL,
    "Retries" integer DEFAULT 0,
    "Priority" integer DEFAULT 0,
    CONSTRAINT "outbox_Coding_check" CHECK ((("Coding")::text = ANY (ARRAY[('Default_No_Compression'::character varying)::text, ('Unicode_No_Compression'::character varying)::text, ('8bit'::character varying)::text, ('Default_Compression'::character varying)::text, ('Unicode_Compression'::character varying)::text]))),
    CONSTRAINT "outbox_DeliveryReport_check" CHECK ((("DeliveryReport")::text = ANY (ARRAY[('default'::character varying)::text, ('yes'::character varying)::text, ('no'::character varying)::text])))
);


ALTER TABLE outbox OWNER TO dimas;

--
-- Name: outbox_ID_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE "outbox_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "outbox_ID_seq" OWNER TO dimas;

--
-- Name: outbox_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE "outbox_ID_seq" OWNED BY outbox."ID";


--
-- Name: outbox_multipart; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE outbox_multipart (
    "Text" text,
    "Coding" character varying(255) DEFAULT 'Default_No_Compression'::character varying NOT NULL,
    "UDH" text,
    "Class" integer DEFAULT (-1),
    "TextDecoded" text,
    "ID" integer NOT NULL,
    "SequencePosition" integer DEFAULT 1 NOT NULL,
    CONSTRAINT "outbox_multipart_Coding_check" CHECK ((("Coding")::text = ANY (ARRAY[('Default_No_Compression'::character varying)::text, ('Unicode_No_Compression'::character varying)::text, ('8bit'::character varying)::text, ('Default_Compression'::character varying)::text, ('Unicode_Compression'::character varying)::text])))
);


ALTER TABLE outbox_multipart OWNER TO dimas;

--
-- Name: outbox_multipart_ID_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE "outbox_multipart_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "outbox_multipart_ID_seq" OWNER TO dimas;

--
-- Name: outbox_multipart_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE "outbox_multipart_ID_seq" OWNED BY outbox_multipart."ID";


--
-- Name: parroquia; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE parroquia (
    codigo_parroquia integer NOT NULL,
    nombre_parroquia character varying NOT NULL
);


ALTER TABLE parroquia OWNER TO dimas;

--
-- Name: TABLE parroquia; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE parroquia IS 'tabla que almacenara las parroquias.';


--
-- Name: parroquia_codigo_parroquia_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE parroquia_codigo_parroquia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parroquia_codigo_parroquia_seq OWNER TO dimas;

--
-- Name: parroquia_codigo_parroquia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE parroquia_codigo_parroquia_seq OWNED BY parroquia.codigo_parroquia;


--
-- Name: phones; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE phones (
    "ID" text NOT NULL,
    "UpdatedInDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "InsertIntoDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "TimeOut" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "Send" boolean DEFAULT false NOT NULL,
    "Receive" boolean DEFAULT false NOT NULL,
    "IMEI" character varying(35) NOT NULL,
    "IMSI" character varying(35) NOT NULL,
    "NetCode" character varying(10) DEFAULT 'ERROR'::character varying,
    "NetName" character varying(35) DEFAULT 'ERROR'::character varying,
    "Client" text NOT NULL,
    "Battery" integer DEFAULT (-1) NOT NULL,
    "Signal" integer DEFAULT (-1) NOT NULL,
    "Sent" integer DEFAULT 0 NOT NULL,
    "Received" integer DEFAULT 0 NOT NULL
);


ALTER TABLE phones OWNER TO dimas;

--
-- Name: sentitems; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE sentitems (
    "UpdatedInDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "InsertIntoDB" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "SendingDateTime" timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone NOT NULL,
    "DeliveryDateTime" timestamp(0) without time zone,
    "Text" text NOT NULL,
    "DestinationNumber" character varying(20) DEFAULT ''::character varying NOT NULL,
    "Coding" character varying(255) DEFAULT 'Default_No_Compression'::character varying NOT NULL,
    "UDH" text NOT NULL,
    "SMSCNumber" character varying(20) DEFAULT ''::character varying NOT NULL,
    "Class" integer DEFAULT (-1) NOT NULL,
    "TextDecoded" text DEFAULT ''::text NOT NULL,
    "ID" integer NOT NULL,
    "SenderID" character varying(255) NOT NULL,
    "SequencePosition" integer DEFAULT 1 NOT NULL,
    "Status" character varying(255) DEFAULT 'SendingOK'::character varying NOT NULL,
    "StatusError" integer DEFAULT (-1) NOT NULL,
    "TPMR" integer DEFAULT (-1) NOT NULL,
    "RelativeValidity" integer DEFAULT (-1) NOT NULL,
    "CreatorID" text NOT NULL,
    CONSTRAINT "sentitems_Coding_check" CHECK ((("Coding")::text = ANY (ARRAY[('Default_No_Compression'::character varying)::text, ('Unicode_No_Compression'::character varying)::text, ('8bit'::character varying)::text, ('Default_Compression'::character varying)::text, ('Unicode_Compression'::character varying)::text]))),
    CONSTRAINT "sentitems_Status_check" CHECK ((("Status")::text = ANY (ARRAY[('SendingOK'::character varying)::text, ('SendingOKNoReport'::character varying)::text, ('SendingError'::character varying)::text, ('DeliveryOK'::character varying)::text, ('DeliveryFailed'::character varying)::text, ('DeliveryPending'::character varying)::text, ('DeliveryUnknown'::character varying)::text, ('Error'::character varying)::text])))
);


ALTER TABLE sentitems OWNER TO dimas;

--
-- Name: sentitems_ID_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE "sentitems_ID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "sentitems_ID_seq" OWNER TO dimas;

--
-- Name: sentitems_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE "sentitems_ID_seq" OWNED BY sentitems."ID";


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: dimas; Tablespace: 
--

CREATE TABLE usuarios (
    cedula integer NOT NULL,
    nombre_usuario character varying(60) NOT NULL,
    apellido_usuario character varying(60) NOT NULL,
    usuario character varying(50) NOT NULL,
    pass character varying(50) NOT NULL,
    nivel_acceso integer NOT NULL,
    status integer NOT NULL,
    fecha_registro date DEFAULT now() NOT NULL,
    hora_registro time without time zone DEFAULT now() NOT NULL
);


ALTER TABLE usuarios OWNER TO dimas;

--
-- Name: codigo_cargo; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY cargo ALTER COLUMN codigo_cargo SET DEFAULT nextval('cargo_codigo_cargo_seq'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY inbox ALTER COLUMN "ID" SET DEFAULT nextval('"inbox_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY outbox ALTER COLUMN "ID" SET DEFAULT nextval('"outbox_ID_seq"'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY outbox_multipart ALTER COLUMN "ID" SET DEFAULT nextval('"outbox_multipart_ID_seq"'::regclass);


--
-- Name: codigo_parroquia; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY parroquia ALTER COLUMN codigo_parroquia SET DEFAULT nextval('parroquia_codigo_parroquia_seq'::regclass);


--
-- Name: ID; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY sentitems ALTER COLUMN "ID" SET DEFAULT nextval('"sentitems_ID_seq"'::regclass);


--
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY cargo (codigo_cargo, nombre_cargo) FROM stdin;
1	TREN EJECUTIVO
2	FUERZA VIVA
3	ALCALDES
5	EQUIPO POLITICO
4	LEGISLADORES
6	DIPUTADOS
7	MISIONES
8	MILITANTES
9	CLAP - GUANARE
\.


--
-- Name: cargo_codigo_cargo_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('cargo_codigo_cargo_seq', 9, true);


--
-- Data for Name: centro_votacion; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY centro_votacion (codigo_centro, codigo_parroquia, nombre_centro, direccion_centro, n_eje, sector) FROM stdin;
1	1	la comunidad	liceo la comunidad nueva	1	\N
160301003	1	ESCUELA BASICA ESTADAL HORTENCIA PERAZA	BARRIO: LOS CORTIJOS. FRENTE TRANSVERSAL CINCO. DERECHA CALLE DOS. REFERENCIA DIAGONAL MATADERO MUNICIPAL BARRIO LOS CORTIJOS GUANARE	1A	1
160301004	1	CASA DE SALUD	BARRIO: MEDERO. FRENTE AVENIDA SIMON BOLIVAR. IZQUIERDA PROLONGACIÓN AL LADO IUTEP PORTUGUESA. REFERENCIA FRENTE A DOÑA PARRILLA	1A	1
160301005	1	ESCUELA BASICA AMADIO MARQUEZ	BARRIO SANTA MARIA IZQUIERDA CALLE INDUSTRIAL. FRENTE CALLE PRINCIPAL 5 DE JULIO. DERECHA CARRERA 1 CALLE PRINCIPAL BARRIO SANTA MARIA GUANARE CASA	1A	1
160301006	1	ESCUELA BASICA TRADICIONAL NUMERO 469 ANTONIO JOSE DE SUCRE	BARRIO: MEDERO 2. FRENTE CALLE PRINCIPAL. IZQUIERDA PROLONGACIÓN CALLE EL MANGO. DERECHA CALLE BOLIVAR. REFERENCIA SEGUNDA CALLE BARRIO EL MEDERO GUANARE	1A	1
160301007	1	ESCUELA BASICA ESTADAL RAFAEL ROBERTO GAVIDIA	BARRIO: LA VICTORIA. FRENTE CALLE PRINCIPAL	1A	1
160301008	1	NUCLEO RURAL NUMERO 289 ESCUELA ESTADAL NUMERO 49.	CASERÍO: BOQUERON. FRENTE CARRETERA CASERIO BOQUERON. REFERENCIA CASERIO BOQUERON	1A	1
160301047	1	ESCUELA CONCENTRADA 19 DE ABRIL	CASERÍO: BARRIO 19 DE ABRIL SECTOR 1. FRENTE AVENIDA PRINCIPAL. REFERENCIA AL LADO DE LA IGLESIA Y FRENTE AL CANAL	1A	1
160301073	1	PRE-ESCOLAR JUAN PABLO SEGUNDO	URBANIZACIÓN: JUAN PABLO II. FRENTE CALLE LA SOLEDAD. REFERENCIA MANZANA F 15	1A	1
160301080	1	UNIDAD EDUCATIVA JOSE DE LOS SANTOS URRIOLA	BARRIO: 19 DE ABRIL. IZQUIERDA CALLE PRINCEPAL. REFERENCIA AL FRENTE DE LA BLOQUERA SAN FRANCISCO DE ASIS	1A	1
160301082	1	ESC. BOLIVARIANA  SOL DE JUSTICIA	BARRIO: SOL DE JUSTICIA. FRENTE CALLE 9. IZQUIERDA AVENIDA 3. DERECHA AVENIDA 2. REFERENCIA SECTOR 1	1A	1
160301010	1	JARDIN DE INFANCIA	URBANIZACIÓN: FRANCISCO DE MIRANDA. FRENTE CALLE 5. IZQUIERDA VEREDA 19. DERECHA VEREDA 12. REFERENCIA AL LADO DE LA CASA COMUNAL	2A	2
160301011	1	CENTRO DE ATENCION INTEGRAL	URBANIZACIÓN: JOSE ANTONIO PAEZ. FRENTE CALLE CUATRO. IZQUIERDA CAMINO CAMPITO. DERECHA CAMINO CAMPITO. REFERENCIA AL LADO DE LA COMISARIA LOS PROCERES	2A	2
160301012	1	COLEGIO UNIVERSITARIO FERMIN TORO	SECTOR LOS PROCERES FRENTE AVENIDA RIO MEDERO. DERECHA CALLEJÓN 02. IZQUIERDA CALLEJÓN 01 SECTOR LOS PROCERES, AVENIDA PRINCIPAL, AL LADO DE RADIO ESTELAR EDIFICIO	2A	2
160301014	1	ESCUELA BASICA ORLANDO GIL CASA DIEGO	URBANIZACIÓN: SIMON BOLIVAR. FRENTE CALLE SIETE. IZQUIERDA CALLE CUATRO. DERECHA CALLE CINCO. REFERENCIA DIAGONAL A LA COMISARIA LOS PROCERES	2A	2
160301083	1	ESCUELA BASICA CONCENTRADA JOSE FELIX RIVAS	BARRIO JOSE FELIX RIVAS DERECHA AVENIDA DOS. IZQUIERDA AVENIDA PRINCIPAL. FRENTE CALLE 06 BARRIO JOSE FELIX RIBAS CASA	2A	2
160301036	1	ESCUELA BASICA LIBERTADOR	BARRIO: LIBERTADOR. FRENTE CALLE 2. IZQUIERDA CALLE 2 CONSULTORIO BARRIO ADENTRO. DERECHA AVENIDA 3. REFERENCIA SEGUNDA CALLE BARRIO LIBERTADOR CALLE PRINCIPAL GUANARE	2B	3
160301044	1	ESCUELA ESTADAL BASICA NICOMEDES CASTILLO	BARRIO: LA IMPORTANCIA. FRENTE CALLE DOS. IZQUIERDA CALLE TRES. DERECHA CALLE CUATRO. REFERENCIA A DOS CUADRAS DE DEL MERCADO MUNICIPAL GUANARE	2B	3
160301045	1	PRE ESCOLAR MATILDE DE PIERLUISSI	URBANIZACIÓN: EL PLACER. FRENTE AVENIDA PALMA REAL. REFERENCIA URBANIZACION EL PLACER PRIMERA CALLE GUANARE	2B	3
160301046	1	ESCUELA BASICA ESTADAL 530	BARRIO: CUATRICENTENARIO. FRENTE AVENIDA JOSE FELIX RIBAS. IZQUIERDA AVENIDA LOS MALABARES. DERECHA CALLE 2. REFERENCIA BARRIO CUATRICENTENARIO	2B	3
160301048	1	ESCUELA BASICA DOCTOR CARLOS RODRIGUEZ ORTIZ	BARRIO: EL CAMBIO. FRENTE CALLE DOS. REFERENCIA DETRAS DEL CLUB ITALO	2B	3
160301081	1	JARDIN DE INFANCIA JOSE VICENTE DE UNDA	BARRIO: MONSENOR UNDA. FRENTE CALLE 7. IZQUIERDA AVENIDA 2. DERECHA AVENIDA 3. REFERENCIA CALLE 7 ESQUINA AVENIDA 3	2B	3
160301093	1	UNIDAD EDUCATIVA NACIONAL CUATRICENTENARIA	BARRIO CUATRICENTENARIO DERECHA CALLE UNO. FRENTE CALLE PRINCINPAL SECTOR UNO AL LADO DEL MODULO POLICIAL CASA	2B	3
160301001	1	LICEO LA COMUNIDAD NUEVA	URBANIZACIÓN: LA COMUNIDAD. FRENTE CALLE 5. DERECHA CALLE PRINCIPAL. REFERENCIA SECTOR 2, FRENTE DE LA FOTOCOPIADORA	4A	4
160301013	1	ESCUELA BASICA GIRALUNA	URBANIZACIÓN: ANDRES ELOY BLANCO. FRENTE AVENIDA VADEKER. IZQUIERDA AVENIDA CANTO ESPANA. DERECHA AVENIDA RENUNCIA. REFERENCIA FRENTE AL MODULO POLICIAL	4A	4
160301015	1	FACULTAD DE MEDICINA EXTENCION GUANARE	URBANIZACIÓN: ANDRES ELOY BLANCO. FRENTE PROLONGACIÓN AVENIDA LIMONERO. REFERENCIA AL LADO DEL IPASME	4A	4
160301019	1	CICLO COMBINADO JOSE VICENTE DE UNDA	BARRIO: MATURIN 2. FRENTE AVENIDA UNDA. IZQUIERDA CARRERA 13. DERECHA CARRERA 14. REFERENCIA AVENIDA UNDA BARRIO MATURIN GUANARE	4A	4
160301020	1	ESCUELA POPULAR CATOLICA FE Y ALEGRIA	BARRIO: MATURIN FINAL DE LA CARRERA 14. FRENTE CARRERA CATORCE. IZQUIERDA AVENIDA CORREDOR VIAL. DERECHA CALLE CUATRO. REFERENCIA CERCA DEL MODULO FE Y ALEGRIA	4A	4
160301031	1	ESCUELA BASICA ANA DE ZAMBRANO ROA	BARRIO: MATURIN 2. FRENTE AVENIDA UNDA. IZQUIERDA CARRERA 13. DERECHA CALLE 7. REFERENCIA AVENIDA UNDA CON CARRERA 14 GUANARE	4A	4
160301076	1	UNIDAD EDUCATIVA CESAR LIZARDO	BARRIO: MATURIN. FRENTE AVENIDA UNDA. IZQUIERDA CARRERA 15. DERECHA CARRERA 14. REFERENCIA AL FRENTE BANCO BICENTENARIO	4A	4
160301077	1	CENTRO DE BELLAS ARTES AMANDA MUÑOZ	URBANIZACIÓN: VILLA ANDREA. FRENTE AVENIDA LA HILANDERA. IZQUIERDA AVENIDA SIMON BOLIVAR. DERECHA AVENIDA PROLONGACION AV. HILANDERA. REFERENCIA AVENIDA LA HILANDERA, URBANIZACION ANDRES ELOY BLANCO AL LADO DE LA EMISORA FM SUPREMA	4A	4
160301028	1	ESCUELA BASICA CIUDAD DE GUANARE	BARRIO CEMENTERIO FRENTE CALLE 26. DERECHA CARRETERA 11. IZQUIERDA CARRERA 10 DETRAS DEL CEMENTERIO CASA	4A	5
160301030	1	ESCUELA BASICA JUAN FERNANDEZ DE LEON	BARRIO: ARENOSA. FRENTE CALLE QUINCE. IZQUIERDA CARRERA TRECE. DERECHA CARRERA DOCE. REFERENCIA FRENTE A LA ZONA EDUCATIVA	4A	5
160301033	1	JARDIN DE INFANCIA GUANARE INAN	BARRIO: CEMENTERIO. FRENTE CARRERA DOCE. IZQUIERDA CALLE DIECISIETE. DERECHA CALLE DIECISEIS. REFERENCIA AL LADO DE LA PLAZA HENRRY PETEERT	4A	5
160301037	1	ESCUELA BASICA NACIONAL DOCTOR MELITON VARGAS	BARRIO LA PENITA FRENTE CALLE 22. DERECHA CALLEJÓN 1. IZQUIERDA CALLEJÓN SIN NUMERO CALLE 22 NUMERO 0-60 BARRIO LA PEÑITA GUANARE CASA	4A	5
160301061	1	COLEGIO ADVENTISTA ANDRES BELLO	BARRIO: CEMENTERIO. FRENTE CALLE DIECIOCHO. IZQUIERDA CALLE NUEVE. DERECHA CALLE DIEZ. REFERENCIA AL LADO DE LA FARMACIA DEL CENTRO	4A	5
160301016	1	ESCUELA BASICA JOSE MARIA VARGAS	BARRIO: CURAZAO. IZQUIERDA AVENIDA 23 DE ENERO. DERECHA AVENIDA MIRANDA. REFERENCIA CALLE 5 NUMERO 3-64 BARRIO CURAZAO GUANARE	4B	6
160301051	1	ESCUELA BASICA GILBERTO OROPEZA	CASERÍO: EL POTRERO. FRENTE CARRETERA VIA A SURUGUAPO. IZQUIERDA CARRETERA VIA A LA ROMPIA. DERECHA CARRETERA VIA A MESA DE POTRERO. REFERENCIA AL LADO DEL MODULO POLICIAL	1C	12
160301017	1	BIBLIOTECA PUBLICA DOCTOR ALIRIO UGARTE PELAYO	BARRIO: CURAZAO. FRENTE AVENIDA FRANCISCO DE MIRANDA. IZQUIERDA CALLEJÓN COROMOTO. DERECHA CALLE 3-38. REFERENCIA CARRERA 03 FRENTE A LA RESIDENCIA DE GOBERNADORES, BARRIO CURAZAO, GUANARE	4B	6
160301027	1	ESCUELA BASICA VIRGINIA DE RAMOS	BARRIO BUENOS AIRES DERECHA CALLE 1. IZQUIERDA CALLE 2. FRENTE CALLE PRINCIPAL VIA MESA ALTA CALLE 2 BARRIO BUENOS AIRES CASA	4B	6
160301034	1	ESCUELA BASICA DON SIMON RODRIGUEZ	CASERÍO: SANTA ROSA. FRENTE CALLE LA COLINA. IZQUIERDA CALLE PRINCIPAL. DERECHA PROLONGACIÓN BARRIO SANTA ROSA. REFERENCIA BARRIO SANTA ROSA FINAL CALLE PRINCIPAL	4B	6
160301042	1	ESCUELA BASICA DON ANTONIO TORREALBA	BARRIO: BELLO MONTE. FRENTE CALLE EL BOHIO DETRAS SEMINARIO. IZQUIERDA CALLE BOLIVAR. DERECHA CALLE 2. REFERENCIA CALLE PRINCIPAL BELLO MONTE SECTOR 2	4B	6
160301072	1	COLEGIO PRIVADO NUESTRA SEÑORA DE LOURDES	BARRIO: MEDERO 1. FRENTE AVENIDA 23 DE ENERO. IZQUIERDA PROLONGACIÓN AVENIDA GIRALUNA. REFERENCIA DIAGONAL A LA CLINICA DEL ESTE	4B	6
160301075	1	UNIDAD EDUCATIVA PRIVADA COLEGIO CATOLICO SAN JOSE	BARRIO BARRIO CURAZAO FRENTE CALLE 10. DERECHA CARRERA 3. IZQUIERDA CARRERA 4 DIAGONAL FARMA ASISTENCIA CASA	4B	6
160301085	1	CENTRO DE ATENCION AL NIÑO  DOÑA BOLIVIA RIERA DE MARTINEZ	BARRIO: GUAICAIPURO. FRENTE AVENIDA PRINCIPAL. IZQUIERDA CALLEJÓN SIN NUMERO. DERECHA CALLE 22. REFERENCIA BARRIO GUAICAIPURO CALLE PRINCIPAL CON AVENIDA LOS COSPES CERCA DEL MODULO POLICIAL	4B	6
160301088	1	ESCUELA BASICA CONCENTRADA SIN NUMERO 5 DE JULIO	BARRIO 5 DE JULIO DERECHA AVENIDA SIMON BOLIVAR. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLEJÓN 2 AL LADO DE LA CANCHA CASA	4B	6
160301021	1	ESCUELA ANDRES ELOY BLANCO	BARRIO: LA PASTORA. FRENTE CALLE QUINCE. REFERENCIA CARRETERA VIA GATO NEGRO BARRIO LA PASTORA GUANARE	3A	7
160301022	1	CENTRO MATERNAL BLANCA R. PEREZ	URBANIZACIÓN: LOS PINOS. FRENTE CALLE PINCIPAL. REFERENCIA A 300 METROS DE LA VIGILANCIA DE LA URBANIZACION	3A	7
160301023	1	GRUPO ESCOLAR NACIONAL DIEGO ANTONIO BRICEÑO	BARRIO: EL PROGRESO. FRENTE CALLE 8. IZQUIERDA CALLE 17. DERECHA CALLE 16. REFERENCIA AL LADO DEL MODULO POLICIAL	3A	7
160301024	1	ESCUELA BASICA ESTADAL GUILLERMO GAMARRA MARRERO	BARRIO: NUEVAS BRISAS. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLE 28. DERECHA CALLEJÓN 1. REFERENCIA BARRIO NUEVAS BRISAS, CALLE 01, DETRAS DEL HOTEL LA SULTANA	5A	7
160301025	1	ESCUELA BASICA ARNOLDO JOSE PERAZA	BARRIO: LAS AMERICAS. FRENTE AVENIDA 5 DE MAYO. IZQUIERDA CALLE 6. DERECHA AVENIDA LIBERTADOR. REFERENCIA AL LADO DE LA CANCHA DEPORTIVA	5A	7
160301026	1	ESCUELA BASICA PROFESORA CELINDA ADAMS	BARRIO: SAN ANTONIO. FRENTE CALLE 2. IZQUIERDA CALLEJÓN 2. DERECHA CALLEJÓN 1. REFERENCIA BARRIO SAN ANTONIO	5A	7
160301032	1	ESCUELA TECNICA INDUSTRIAL GUANARE	SECTOR: LOS GUASIMITOS LOS PINOS Y EL PARAISO BOLIVARIANO. FRENTE AVENIDA 3 DE NOVIEMBRE. IZQUIERDA PROLONGACIÓN SECTOR LOS CANALES. DERECHA AVENIDA LA GRANJA. REFERENCIA VIA URBANIZACION LOS PINOS GATO NEGRO SECTOR LOS CANALES	3A	7
160301074	1	PRE-ESCOLAR LOS LLANERITOS	BARRIO: EL PROGRESO. FRENTE CALLE 18. IZQUIERDA CALLEJÓN 2. DERECHA AVENIDA SIMON BOLIVAR. REFERENCIA CALLE 18 SECTOR 01 BARRIO EL PROGRESO	3A	7
160301084	1	CENTRO EDUCATIVO RECREACIONAL  GRISELDA DE LA RIVA	BARRIO: EL PROGRESO. FRENTE CALLEJÓN 3. IZQUIERDA CALLE 16 . DERECHA CALLE 15. REFERENCIA DETRÁS DEL MODULO POLICAL	3A	7
160301086	1	ESCUELA GENERAL CARLOS SOUBLETTE	URBANIZACIÓN CAFI Y CAFE DERECHA CALLE PRINCIPAL. FRENTE CALLE LOS COCOS VIA PAPELON URBANIZACION CAFI Y CAFÉ, DIAGONAL AL HOTEL CALIFORNIA CASA	3A	7
160301029	1	CICLO DIVERCIFICADO CARLOS EMILIO MUÑOZ ORAA	BARRIO: SUCRE. FRENTE CALLE 4. IZQUIERDA PROLONGACIÓN CALLE 2. DERECHA AVENIDA JUAN FERNANDEZ DE LEON. REFERENCIA AL LADO CAMPO FUTBOL	5A	8
160301038	1	ESCUELA BASICA NACIONAL DOCTOR MIGUEL ORAA	BARRIO: SUCRE. FRENTE CARRERA 1. IZQUIERDA CALLE 3. DERECHA CALLE 5. REFERENCIA CALLE PRINCIPAL NUMERO 3-68	5A	8
160301039	1	ESCUELA ESTADAL CONCENTRADA BASICA NUMERO 33	BARRIO: LAS FLORES. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLEJÓN 1. DERECHA AVENIDA PORTUGAL. REFERENCIA DIAGONAL A LA CASA DE ALIMENTACION DE FUNDAPROAL	5B	8
160301040	1	CICLO BASICO COMBINADO DOCTOR FELIX SATURNINO ARISA	BARRIO: SAN JOSE. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLE 1. DERECHA AVENIDA JUAN FERNANDEZ DE LEON. REFERENCIA DIAGONAL PARQUE FERIAL JOSE ANTONIO PAEZ	5A	8
160301043	1	INTERNADO JUDICIAL	BARRIO: SAN RAFAEL DE LA COLONIA PARTE BAJA. FRENTE CARRETERA NACIONAL VIA A BARINA. IZQUIERDA CALLE 1. DERECHA CALLE 2. REFERENCIA AL LADO DE CIRCUNSCRIPCION MILITAR DE GUANARE	5B	9
160301057	1	ESCUELA BASICA LUIS FAJARDO GALENO	BARRIO: LA COLONIA PARTE BAJA. FRENTE AVENIDA SIMON BOLIVAR. IZQUIERDA PROLONGACIÓN URBANIZACION COLINAS DE ITALVEN. DERECHA CARRETERA VIA A BISCUCUY. REFERENCIA AL LADO DE ALINEACION LA COLONIA	5B	9
160301059	1	ESCUELA BASICA MARIA CONCEPCION PALACIOS	BARRIO LA ENRIQUERA DERECHA AVENIDA SIMON BOLIVAR. FRENTE CALLE PRINCIPAL. IZQUIERDA PROLONGACIÓN CALLE PRINCIPAL AL LADO MODULO BARRIO ADENTRO CDI CASA	5B	9
160301060	1	ESCUELA BASICA SAN RAFAEL NUMERO 467	BARRIO: SAN RAFAEL SECTOR 1. FRENTE CALLE PRINCIPAL. IZQUIERDA CARRETERA NACIONAL VIA A BARINAS. DERECHA CALLEJÓN 1. REFERENCIA AL LADO DE MERCALITO	5B	9
160301067	1	ESCUELA ESTADAL CONCENTRADA NUMERO 9	CASERÍO: LAS PANELAS. FRENTE CARRETERA VIA LA REPRESA. REFERENCIA CASERIO LAS PANELAS	5B	9
160301049	1	ESCUELA BASICA MIGUEL ANTONIO VASQUEZ	CASERÍO: ASENTAMIENTO GATO NEGRO. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLE 2. DERECHA CALLEJÓN 1. REFERENCIA ASENTAMIENTO JOSE ANTONIO PAEZ GATO NEGRO	3B	10
160301050	1	ESCUELA ESTADAL GRADUADA NUMERO 16 LA CURVA TERESA DE LA PARRA	CASERÍO: CURVA. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLEJÓN 1. DERECHA CARRETERA VIA A MORITA. REFERENCIA CASERIO LA CURVA	3B	10
160301054	1	ESCUELA CONCENTRADA MIXTA NUMERO 1810-82	CASERÍO: QUEBRADA DEL MAMON. FRENTE CARRETERA PRINCIPAL VIA AL RINCON. REFERENCIA CASERIO QUEBRADA DEL MAMON	1B	11
160301055	1	ESCUELA CONCENTRADA MIXTA NUMERO 14	CASERÍO: EL RINCON. FRENTE CARRETERA VIA A QUEBRADA DEL MAMON. REFERENCIA CASERIO EL RINCON VIA LA QUEBRADA DEL MAMON	1B	11
160301056	1	ESCUELA CONCENTRADA MIXTA NUMERO 1808 Y 90	CASERÍO: LAS MATAS. FRENTE CALLE DOS. IZQUIERDA AVENIDA CUATRO. REFERENCIA CASERIO LAS MATAS FRENTE A LA PLAZA BOLIVAR Y DIAGONAL A LA CANCHA	1B	11
160301065	1	ESCUELA BOLIVARIANA SAN RAFAEL DE LAS GUASDUAS NUMERO 51	CASERÍO: SAN RAFAEL DE LAS GUASDUAS. IZQUIERDA CALLE PRINCIPAL. REFERENCIA CARRETERA NACIONAL CASERIO SAN RAFAEL DE LAS GUASDUAS	1B	11
160301066	1	ESCUELA ESTADAL CONCENTRADA NUMERO 48	CASERÍO: LAS COCUIZA. FRENTE CARRETERA TONCAL 5. REFERENCIA CASERIO LAS COCUIZAS CARRETERA GUANARE ACARIGUA	1B	11
160301071	1	ESCUELA GRADUADA BASICA TIERRA BUENA	CASERÍO: TIERRA BUENA. FRENTE CARRERA UNO. DERECHA CALLE CUATRO. REFERENCIA CASERIO TIERRA BUENA CARRERA 1 CON CALLE 4	1B	11
160304006	4	ESCUELA ESTADAL NUMERO 07 Y ANEXA NACIONAL	CASERÍO LA FLECHA FRENTE AVENIDA JUAN PABLO II FRENTE A LA CANCHA CASA		15
160301052	1	ESCUELA MULTIGRADO NACIONAL SIN NUMERO	CASERÍO: PANTALEONERO. FRENTE CARRETERA VIA HACIA LOS TOROS. REFERENCIA CASERIO EL PANTALEONERO	1C	12
160301053	1	ESCUELA ESTADAL MULTIGRADO NUMERO 55 EL PUENTE	CASERÍO: BOCA DE MONTE. FRENTE CARRERA VIA RAYA DE GUARICO. REFERENCIA CASERIO EL PUENTE DE  LAS MARIAS FRENTE AL DISPENSARIO	1C	12
160301062	1	ESCUELA CONCENTRADA MIXTA NUMERO 53	CASERÍO: SAN JOSE DE LA MONTANA. FRENTE CARRETERA VIA RAYA DE GUARICO. REFERENCIA CASERIO SAN JOSE DE LA MONTAÑA	1C	12
160301064	1	ESCUELA ESTADAL MULTIGRADO NUMERO 222	CASERÍO: LA RAYA DE GUARICO. FRENTE CARRETERA VIA A SAN JOSE DE LA MONTANA. REFERENCIA CASERIO LA RAYA DE GUARICO	1C	12
160301068	1	ESCUELA BASICA NACIONAL CONCENTRADA SIN NUMERO	CASERÍO: MEDIA LUNA. FRENTE CARRETERA NACIONAL VIA SURUGUAPO. IZQUIERDA CARRETERA NACIONAL VIA SURUGUAPO. DERECHA CARRETERA NACIONAL VIA SURUGUAPO. REFERENCIA AL LADO DEL CONSULTORIO BARRIO ADENTRO	1C	12
160301069	1	ESCUELA ESTADAL CONCENTRADA NUMERO 15 NUCLEO ESCOLAR RURAL NUMERO 289	CASERÍO: LAS MARIA 2. FRENTE CARRETERA VIA A SURUGUAPO. IZQUIERDA PROLONGACIÓN VIA A SURUGUAPO. DERECHA PROLONGACIÓN VIA A SURUGUAPO. REFERENCIA CASERIO LAS MARIAS II, CARRETERA NACIONAL VIA SURUGUAPO	1C	12
160301070	1	ESCUELA BASICA UNITARIA NUMERO 56	CASERÍO: EL ALGARROBO. FRENTE CARRETERA SAN JOSE DE LA MONTANA. REFERENCIA CASERIO ALGARROBO CARRETERA NACIONAL VIA SURUGUAPO	1C	12
160301090	1	ESCUELA BASICA ESTADAL CONCENTRADA NUMERO 543	CASERÍO EL POTRERITO DERECHA CARRETERA VIA A SURUGUAPO. IZQUIERDA CARRETERA VIA A SURUGUAPO. FRENTE CARRETERA VIA RAYA DE GUARICO A 100 METROS DE LA IGLESIA LUZ DEL MUNDO	1C	12
160301091	1	ESCUELA ESTADAL CONCENTRADA SIN NUMERO OJO DE AGUA LA CAMPIÑA NER NUMERO 34	CASERÍO LA CAMPIÑA DE GUANARE IZQUIERDA CARRETERA PATA DE GALLINA. FRENTE CARRETERA VIA GUAYABAL MATA LARGA. DERECHA PROLONGACIÓN PATA DE GALLINA BODEGA DE PATA DE GALLINA	1C	12
160301002	1	ESCUELA ESTADAL UNITARIA NUMERO 81	CASERÍO: BELLA VISTA EL COCO. FRENTE CALLE PRINCIPAL. IZQUIERDA PROLONGACIÓN CALLE PRINCIPAL. DERECHA PROLONGACIÓN CALLE PRINCIPAL. REFERENCIA AL LADO DE LA BODEGA DE LINO AGUILAR		13
160301089	1	ESCUELA ESTADAL CONCENTRADA NUMERO 76 BUENA VISTA EL COCO	CASERÍO BUENA VISTA EL COCO FRENTE CALLE PRINCIPAL. DERECHA CARRETERA VIA VILLA NUEVA. IZQUIERDA CARRETERA VIA CASERIO SAN JUAN AL LADO DEL AMBULATORIO RURAL		13
160302001	2	ESCUELA BASICA CORDOBA	CASERÍO: CORDOBA. FRENTE CALLE PRINCIPAL. REFERENCIA CASERIO CORDOBA		13
160302002	2	ESCUELA ESTADAL CONCENTRADA NUMERO 78	CASERÍO BOTUCAL FRENTE CARRETERA VIA SAN JOSE DE LA MONTANA CASERIO BOTUCAL CASA		13
160302003	2	ESCUELA NACIONAL UNITARIA NUMERO 118 ANEXA CON MIXTA NUMERO 73	CASERÍO: LA MONTANA DE CORDOBA. FRENTE CALLE DE LA IGLESIA CATOLICA. IZQUIERDA CALLEJÓN PRINCIPAL. REFERENCIA LA MONTAÑA CORDOBA		13
160302004	2	ESCUELA NACIONAL UNITARIA NUMERO 211	CASERÍO: PALO SOLO. FRENTE CARRETERA VIA A SAN RAFAEL. REFERENCIA CASERIO PALO SOLO		13
160302005	2	ESCUELA ESTADAL UNITARIA NUMERO 260	CASERÍO SAN ISIDRO IZQUIERDA CARRETERA VIA BARRIO SAN ANTONIO. FRENTE CARRETERA VIA DESEMBOCADERO VILLA ROSA. DERECHA PROLONGACIÓN VIA BARRIO SAN ANTONIO AL LADO DEL LICEO CASA		13
160302006	2	ESCUELA ESTADAL CONCENTRADA NUMERO 79	CASERÍO SAN RAFAEL DE CORDOBA FRENTE CALLE PRINCIPAL. IZQUIERDA CARRETERA SECTOR LA FILA. DERECHA PROLONGACIÓN CALLE PRINCIPAL AL FRENTE DEL TANQUE DE AGUA		13
160301063	1	ESCUELA CONCENTRADA NUMERO 44	CASERÍO LAS FILAS DERECHA CARRETERA VIA FAMILIA ESCALONA. IZQUIERDA CARRETERA VIA A CORREDORES. FRENTE CARRETERA VIA FAMILIA ESCALONA CASERIO LAS FILAS CASA		14
160303001	3	ESCUELA GRANJA OSCAR VILLANUEVA ANEXA NUMERO 390	URBANIZACIÓN: LA COLONIA PARTE ALTA. FRENTE CALLE PRINCIPAL. REFERENCIA LA COLONIA DE GUANARE		14
160303002	3	ESCUELA BASICA 3 DE NOVIEMBRE	SECTOR EL VALLE FRENTE AVENIDA PRINCIPAL. DERECHA CALLE HERRERA CARMONA. IZQUIERDA CALLE RIBAS AVENIDA PRINCIPAL DE MESA DE CAVACAS ENTRE CALLES RIBAS Y HERRERA CARMONA CASA		14
160303003	3	ESCUELA BASICA CONCENTRADA NUMERO 490	CASERÍO: MESA ALTA SECTOR 2. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLEJÓN 1. DERECHA PROLONGACIÓN CALLE PRINCIPAL. REFERENCIA MESA ALTA II		14
160303004	3	ESCUELA ESTADAL CONCENTRADA NUMERO 47	BARRIO: EZEQUIEL ZAMORA. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLEJÓN DOS. REFERENCIA BARRIO EZEQUIEL ZAMORA LA RECTA		14
160303005	3	UNIDAD EDUCATIVA NACIONAL SAN JUAN DE GUANAGUANARE	BARRIO: MATA VERDE. FRENTE CALLE PRINCIPAL. IZQUIERDA CALLE HERRERA CARMONA. REFERENCIA CALLE PRINCIPAL ENTRE HERRERA CARMONA		14
160303006	3	UNIDAD CONCENTRADA NUMERO 277	CASERÍO: CERRO DE PAJA. FRENTE CARRETERA VIA RIO ANUS. REFERENCIA CARRETERA RIO DE ANUS		14
160303007	3	ESCUELA ESTADAL NUMERO 10 Y ANEXA NACIONAL	CASERÍO: LOS TORENOS. FRENTE CARRETERA NACIONAL VIA A BISCUCUY. REFERENCIA CARRETERA GUANARE-BISCUCUY, CASERIO LOS TOREÑOS		14
160303008	3	ESCUELA BASICA ESTADAL SIMON BOLIVAR	CASERÍO DESEMBOCADERO FRENTE CALLE PRINCIPAL CARRETERA GUANARE-BISCUCUY, CASERIO DESEMBOCADERO DIAGONAL AL AMBULATORIO CASA		14
160303009	3	ESCUELA BASICA CONCENTRADA NUMERO 42	CASERÍO: LA TORREALBERA. FRENTE CARRETERA VIA AL PAJON UNO Y DOS. REFERENCIA CASERIO LA TOREALBERA VIA AL PAJON UNO Y DOS		14
160303010	3	ESCUELA UNITARIA SIN NUMERO EL BUEY	CASERÍO: LAS LLANADAS DEL BUEY. FRENTE CARRETERA PRINCIPAL DEL CASERIO LAS LLANADAS DEL BUEY. REFERENCIA CASERIO LAS LLANADAS CARRETERA VIA BISCUCUY (EL BUEY) KILOMETRO 13		14
160303011	3	ESCUELA ESTADAL CONCENTRADA LOLA DE PACHECO	BARRIO: LA AMISTAD. FRENTE CALLE LOS CHAGUARAMOS. IZQUIERDA CALLE PRINCIPAL. REFERENCIA BARRIO LA AMISTAD COLONIA PARTE ALTA DIAGONAL A LA IGLESIA		14
160303013	3	CENTRO CULTURAL DON ANTONIO TORREALBA MESA DE CAVACA	BARRIO CENTRO MESA DE CAVACA FRENTE AVENIDA GABALDON. DERECHA CALLE CARMONA. IZQUIERDA CALLE RIVAS FRENTE A LA PLAZA BOLIVAR Y AL LADO MODULO POLICIAL CASA		14
160303014	3	ESCUELA BASICA ESTADAL CONCENTRADA LAS PLAYITAS NUMERO 5NER 11	CASERÍO RIO ANUS SECTOR LAS PLAYITAS FRENTE CALLE PRINCIPAL. DERECHA PROLONGACIÓN VIA A CASERIO CERRO PAJA. IZQUIERDA PROLONGACIÓN VIA A CASERIO SANTA LUCIA AL LADO DEL MERCAL CASA		14
160304001	4	UNIDAD EDUCATIVA NACIONAL TUCUPIDO	CASERÍO: TUCUPIDO. FRENTE CARRETERA TONCAL 5 VIA A BARINAS. REFERENCIA AL LADO DEL AMBULATORIO		15
160304002	4	E.T.C QUEBRADA DE LA VIRGEN	CASERÍO QUEBRADA DE LA VIRGEN DERECHA CALLE BARRIO NUEVO. IZQUIERDA CALLE AMBULATORIO. FRENTE CALLE JUAN PABLO SEGUNDO CARRETERA NACIONAL GUANARE QUEBRADA DE LA VIRGEN EDIFICIO		15
160304003	4	ESCUELA ESTADAL CONCENTRADA NUMERO 12 Y ANEXA NACIONAL	CASERÍO: BARRANCONES. FRENTE AVENIDA JUAN PABLO II. IZQUIERDA CALLEJÓN SECTOR 2. REFERENCIA VIA BASILICA MENOR		15
160304004	4	ESCUELA ESTADAL CONCENTRADA NUMERO 11 NUCLEO 30	CASERÍO: VEGA DEL BRAZO. FRENTE CALLE PRINCIPAL VIA LOS PLAYONES. REFERENCIA FRENTE A LA CANCHA DE VEGA DEL BRAZO		15
160304005	4	ESCUELA ESTADAL UNITARIA NUMERO 64	CASERÍO: SAN JOSE DE GUAFILLAS. FRENTE CARRETERA TRONCAL 5 VIA A BARINAS. REFERENCIA AL LADO DEL COMANDO DE LA GUARDIA GUAFILLAS		15
160304007	4	ESCUELA ESTADAL CONCENTRADA NUMERO 23	CASERÍO: EL VOLCAN. FRENTE CARRETERA VIA AL EMBALSE LA COROMOTO. REFERENCIA CASERIO EL VOLCAN VIA AL EMBALSE LA COROMOTO		15
160304008	4	ESCUELA ESTATAL CONCENTRADA  546 LOS HIERROS	CASERÍO LOS HIERROS TUCUPIDO VIA AL EMBALSE FRENTE CARRETERA VIA AL EMBALSE LA COROMOTO. DERECHA PROLONGACIÓN VIA AL EMBALSE LA COROMOTO. IZQUIERDA PROLONGACIÓN VIA AL EMBALSE LA COROMOTO A LADO CENTRO SOCIAL EL EMBALSE		15
160304009	4	ESCUELA ESTADAL UNITARIA NUMERO 529 NER 30	CASERÍO PEÑA Y ARAUQUITA FRENTE CALLE PRINCIPAL. IZQUIERDA SENDERO SECTOR LA PEÑA. DERECHA CAMINO LA CAÑADA RECEPTORIA DE LECHE		15
160304010	4	ESCUELA BOLIVARIANA NEGRO PRIMERO NER 030	BARRIO NEGRO PRIMERO QUEBRADA DE LA VIRGEN DERECHA AVENIDA PRINCIPAL. IZQUIERDA AVENIDA 2. FRENTE CALLE 1 AL LADO CASA COMUNAL		15
160305001	5	ESCUELA ESTADAL CONCENTRADA NUMERO 205	CASERÍO: SAN JUAN DE LA HONDONADA. REFERENCIA CAS SAN JUAN DE LA HONDONADA GUANARE		16
160305002	5	ESCUELA ESTADAL CONCENTRADA NUMERO 208	CASERÍO: SAN JOSE DE LA MONTANA. REFERENCIA CASERIO SAN JOSE DE LA MONTAÑA		16
160305003	5	ESCUELA BASICA NUMERO 216 NUCLEO RURAL NUMERO 223	CASERÍO: PALMA 1. FRENTE CARRETERA VIA PALMA 2. REFERENCIA CASERIO PALMA I		16
\.


--
-- Data for Name: gammu; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY gammu ("Version") FROM stdin;
16
\.


--
-- Data for Name: inbox; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY inbox ("UpdatedInDB", "ReceivingDateTime", "Text", "SenderNumber", "Coding", "UDH", "SMSCNumber", "Class", "TextDecoded", "ID", "RecipientID", "Processed") FROM stdin;
\.


--
-- Name: inbox_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('"inbox_ID_seq"', 1, false);


--
-- Data for Name: militantes; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY militantes (cedula_militante, codigo_cargo, codigo_parroquia, codigo_centro, nombre_militante, apellido_militante, telefono_militante, foto) FROM stdin;
12648199	9	\N	1	YURIZAN COROMOTO PEREZ BRICEÑO	YURIZAN COROMOTO PEREZ BRICEÑO	04166567789	12648199
25016223	9	\N	1	MARBELYS DEL CARMEN PERAZA PEREZ	MARBELYS DEL CARMEN PERAZA PEREZ	04267541984	25016223
11401157	9	\N	1	CARMEN ELENA JIMENEZ	CARMEN ELENA JIMENEZ	04263523136	11401157
10728487	9	\N	1	ANA JOSEFINA MENA MENDOZA	ANA JOSEFINA MENA MENDOZA	04163523837	10728487
8065805	9	\N	1	JOSE REYES FERNANDEZ BECERRA	JOSE REYES FERNANDEZ BECERRA	04161219334	8065805
12509951	9	\N	1	JANETT YAMILETH MARQUEZ GONZALEZ	JANETT YAMILETH MARQUEZ GONZALEZ	04165412823	12509951
13740141	9	\N	1	GEILIANA JOSEFINA HERNANDEZ DE HEREDIA	GEILIANA JOSEFINA HERNANDEZ DE HEREDIA	04166566325	13740141
16645073	9	\N	1	CHRISTIAN ORLANDO VILLALOBOS LORETO	CHRISTIAN ORLANDO VILLALOBOS LORETO	04263528913	16645073
24907676	9	\N	1	MILCA NOHEMI NAVAS GARCIA	MILCA NOHEMI NAVAS GARCIA	04160573518	24907676
14333480	9	\N	1	YELITZA BEATRIZ GUANIPA QUIROZ	YELITZA BEATRIZ GUANIPA QUIROZ	04269519870	14333480
13960056	9	\N	1	GERSON ALVIDIO NIÑO SILVA	GERSON ALVIDIO NIÑO SILVA	04269393590	13960056
13570446	9	\N	1	LINO ANTONIO DIAZ TORREALBA	LINO ANTONIO DIAZ TORREALBA	04264592587	13570446
12236058	9	\N	1	REINA DEL CARMEN GARCIA RAMOS	REINA DEL CARMEN GARCIA RAMOS	04161288852	12236058
8052466	9	\N	1	GAUDY JOSEFINA PEREZ GONZALEZ	GAUDY JOSEFINA PEREZ GONZALEZ	04245668118	8052466
24018524	9	\N	1	JAIMELIS SARAY MENDOZA ORTEGA	JAIMELIS SARAY MENDOZA ORTEGA	04264353085	24018524
22090206	9	\N	1	ELIDORA GREGORIA MONTILLA TORRES	ELIDORA GREGORIA MONTILLA TORRES	04264534680	22090206
19855919	9	\N	1	YORLANY SARAI YEPEZ SAAVEDRA	YORLANY SARAI YEPEZ SAAVEDRA	04145773610	19855919
14333358	9	\N	1	YAMILETH DEL CARMEN HERNANDEZ PERNIA	YAMILETH DEL CARMEN HERNANDEZ PERNIA	04264516910	14333358
15138333	9	\N	1	MARIA VERONICA ACOSTA BRICEÑO	MARIA VERONICA ACOSTA BRICEÑO	04168571512	15138333
21160984	9	\N	1	DAYANA COROMOTO FUENTES FERNANDEZ	DAYANA COROMOTO FUENTES FERNANDEZ	04161200793	21160984
15349530	9	\N	1	ORLANDO ALEXIS BORJAS LOPEZ	ORLANDO ALEXIS BORJAS LOPEZ	04140558676	15349530
10722007	9	\N	1	FIDELIA COROMOTO ALBORNOZ CALDERON	FIDELIA COROMOTO ALBORNOZ CALDERON	04160257038	10722007
16210312	9	\N	1	NAILE COROMOTO PEREZ GONZALEZ	NAILE COROMOTO PEREZ GONZALEZ	04269530845	16210312
22094021	9	\N	1	TRINA ELENA ESCOBAR SANCHEZ	TRINA ELENA ESCOBAR SANCHEZ	04262769413	22094021
19188400	9	\N	1	LINDA EVANS CASTILLO REQUENA	LINDA EVANS CASTILLO REQUENA	04126114023	19188400
12236371	9	\N	1	CARMEN MIREYA SANCHEZ BRICEÑO	CARMEN MIREYA SANCHEZ BRICEÑO	04167571080	12236371
10050384	9	\N	1	CARMEN PEREZ	CARMEN PEREZ	04269720117	10050384
2729885	9	\N	1	RAMONA SOLEDAD SAAVEDRA MENDOZA	RAMONA SOLEDAD SAAVEDRA MENDOZA	04167503591	2729885
10728334	9	\N	1	YELIXA VICTORIA REINOSA GIL	YELIXA VICTORIA REINOSA GIL	04145760824	10728334
12011147	9	\N	1	OLIVAR JOSE GRATEROL MARCHENA	OLIVAR JOSE GRATEROL MARCHENA	04268558422	12011147
12010662	9	\N	1	CARELIS COROMOTO GARCIA	CARELIS COROMOTO GARCIA	04261086452	12010662
26188012	9	\N	1	KELYN ANAIS GONZALEZ TIMAURE	KELYN ANAIS GONZALEZ TIMAURE	04245695935	26188012
14996650	9	\N	1	JOEL ADAN LOZADA GODOY	JOEL ADAN LOZADA GODOY	04125201613	14996650
17880765	9	\N	1	NORBELYS CAROLINA USECHE MARQUEZ	NORBELYS CAROLINA USECHE MARQUEZ	04145782866	17880765
12011943	9	\N	1	EGLIS MARIBEL RIVAS FRANCO	EGLIS MARIBEL RIVAS FRANCO	04269559453	12011943
11612599	9	\N	1	ALBERTO ENRIQUE PEÑA CRESPO	ALBERTO ENRIQUE PEÑA CRESPO	04167533680	11612599
6384533	9	\N	1	FRANCISCA MARIA RODRIGUEZ	FRANCISCA MARIA RODRIGUEZ	04149503034	6384533
13040244	9	\N	1	MILAGRO JACKELINE HIDALGO HIDALGO	MILAGRO JACKELINE HIDALGO HIDALGO	04264022757	13040244
11175942	9	\N	1	MARIA ANGELICA GOITIA JIMENEZ	MARIA ANGELICA GOITIA JIMENEZ	04125238315	11175942
16646640	9	\N	1	NORELYS DEL CARMEN BASTIDAS	NORELYS DEL CARMEN BASTIDAS	04169482347	16646640
9405889	9	\N	1	YAJAIRA RAMONA GARCIA CASCIATI	YAJAIRA RAMONA GARCIA CASCIATI	2572518852	9405889
19533520	9	\N	1	GLENDY VANESSA URDANETA TORRES	GLENDY VANESSA URDANETA TORRES	04264540479	19533520
15589776	9	\N	1	JORGE ALBERTO SEGOVIA GONZALEZ	JORGE ALBERTO SEGOVIA GONZALEZ	04168557985	15589776
13604695	9	\N	1	YADIRA BARAZARTE GIL	YADIRA BARAZARTE GIL	04121512725	13604695
9250541	9	\N	1	ANGELA CONSTANTINA SALERNO DE GALANTE	ANGELA CONSTANTINA SALERNO DE GALANTE	04145416721	9250541
13328326	9	\N	1	DAVID RAFAEL COLMENARES TERAN	DAVID RAFAEL COLMENARES TERAN	04168515157	13328326
15138748	9	\N	1	YURBY JOSEFINA GUTIERREZ FERNANDEZ	YURBY JOSEFINA GUTIERREZ FERNANDEZ	04166144808	15138748
19528201	9	\N	1	KEILA JOSEFINA MORON COLMENARES	KEILA JOSEFINA MORON COLMENARES	04262567069	19528201
9250587	9	\N	1	GREGORIA RAMONA VALERA BRICEÑO	GREGORIA RAMONA VALERA BRICEÑO	04266589978	9250587
16404965	9	\N	1	AYARY YAMILETH LABASTIDA	AYARY YAMILETH LABASTIDA	04262528181	16404965
18811304	9	\N	1	JUDITH DEL CARMEN PRINCIPAL	JUDITH DEL CARMEN PRINCIPAL	04160503868	18811304
15139058	9	\N	1	JUAN CARLOS CASTILLO GALLARDO	JUAN CARLOS CASTILLO GALLARDO	04168505577	15139058
10480703	9	\N	1	ERWING RADAMES RAMIREZ RUIZ	ERWING RADAMES RAMIREZ RUIZ	04160919178	10480703
5207520	9	\N	1	ROBERTO RAMON FLORES	ROBERTO RAMON FLORES	04163299588	5207520
14731760	9	\N	1	INGRI RAMONA ALVAREZ RODRIGUEZ	INGRI RAMONA ALVAREZ RODRIGUEZ	04267511826	14731760
13960931	9	\N	1	MIRLA DEL VALLE RODRIGUEZ TAMAYO	MIRLA DEL VALLE RODRIGUEZ TAMAYO	04261587338	13960931
3230995	9	\N	1	MIRIAN TERESA RUIZ	MIRIAN TERESA RUIZ	04268562466	3230995
14466821	9	\N	1	DIGNA ROSA GUERRA TORRES	DIGNA ROSA GUERRA TORRES	04165575723	14466821
12009135	9	\N	1	HIDALDO ZUALIN MORILLO AZUAJE	HIDALDO ZUALIN MORILLO AZUAJE	04261146103	12009135
5129272	9	\N	1	OMAR ANTONIO RODRIGUEZ VALERA	OMAR ANTONIO RODRIGUEZ VALERA	2572560734	5129272
20318782	9	\N	1	YUDECSI YANAIR GODOY ZULBARAN	YUDECSI YANAIR GODOY ZULBARAN	04261524523	20318782
25162913	9	\N	1	YONATHAN JESUS ALBERTO TORRES CARDOZA	YONATHAN JESUS ALBERTO TORRES CARDOZA	04261100673	25162913
14466549	9	\N	1	MAIRA ADELAIDA PULIDO RODRIGUEZ	MAIRA ADELAIDA PULIDO RODRIGUEZ	0416058916	14466549
13682410	9	\N	1	YAJAIRA DEL VALLE MONTILLA TERAN	YAJAIRA DEL VALLE MONTILLA TERAN	04165306689	13682410
12648424	9	\N	1	BETZABETH DEL CARMEN FRIAS MARQUEZ	BETZABETH DEL CARMEN FRIAS MARQUEZ	04167438894	12648424
25520484	9	\N	1	MILAGROS MARIFEL RAMOS RODRIGUEZ	MILAGROS MARIFEL RAMOS RODRIGUEZ	04269548238	25520484
20317607	9	\N	1	ERIKA ROSMARY PAREDES	ERIKA ROSMARY PAREDES	04127732685	20317607
3715833	9	\N	1	MIRIAM JAIMES	MIRIAM JAIMES	04167571173	3715833
16072326	9	\N	1	YENNI YAIDI COLMENARES ISAGUIRRE	YENNI YAIDI COLMENARES ISAGUIRRE	04145761152	16072326
19957651	9	\N	1	YUDTHY COROMOTO MARQUEZ PEREZ	YUDTHY COROMOTO MARQUEZ PEREZ	2573113914	19957651
13683855	9	\N	1	NEPTALY JOSE PEREIRA HERNANDEZ	NEPTALY JOSE PEREIRA HERNANDEZ	04163545917	13683855
10059294	9	\N	1	DOMENICO CANTELMI JEWTUSEHENKO	DOMENICO CANTELMI JEWTUSEHENKO	04163662070	10059294
9407550	9	\N	1	SINECIO ANTONIO PERAZA CORTEZ	SINECIO ANTONIO PERAZA CORTEZ	04160258665	9407550
16644441	9	\N	1	NANCY COROMOTO INFANTE DIAZ	NANCY COROMOTO INFANTE DIAZ	04262524152	16644441
11200199	9	\N	1	EVELYN DEYANIRA PANTOJA SALGADO	EVELYN DEYANIRA PANTOJA SALGADO	04268529239	11200199
15799658	9	\N	1	DIRCIA LA CRUZ LEAÑEZ	DIRCIA LA CRUZ LEAÑEZ	2573958676	15799658
4371291	9	\N	1	ELEAZAR MARIA ARIAS	ELEAZAR MARIA ARIAS	04263722176	4371291
18100139	9	\N	1	ENEIDA DESIREE TORREALBA BRAVO	ENEIDA DESIREE TORREALBA BRAVO	04164677403	18100139
18034878	9	\N	1	DAYANA CAROLINA BRICEÑO SALAS	DAYANA CAROLINA BRICEÑO SALAS	04169379784	18034878
19957976	9	\N	1	YULIMAR DEL CARMEN PALMERA HERNANDEZ	YULIMAR DEL CARMEN PALMERA HERNANDEZ	04266142911	19957976
9402047	9	\N	1	OMAR JOSE MARIN URBINA	OMAR JOSE MARIN URBINA	04262516984	9402047
27510383	9	\N	1	KARINA DEL CARMEN FERNANDEZ SIVIRA	KARINA DEL CARMEN FERNANDEZ SIVIRA	04267110757	27510383
11403831	9	\N	1	MARVIN DARIO MENDOZA PEREZ	MARVIN DARIO MENDOZA PEREZ	2573111276	11403831
4931297	9	\N	1	YMMER DAVID RAMIREZ FLORES	YMMER DAVID RAMIREZ FLORES	04140770622	4931297
13467718	9	\N	1	MARIA YOLEIMA MORA CONTRERAS	MARIA YOLEIMA MORA CONTRERAS	04245113108	13467718
8053735	9	\N	1	FAUTINA FERNANDEZ CASTILLO	FAUTINA FERNANDEZ CASTILLO	2573112651	8053735
15905085	9	\N	1	NESTOR GUILLERMO DUQUE DELGADO	NESTOR GUILLERMO DUQUE DELGADO	04261090181	15905085
17351083	9	\N	1	ALY ANTONIO LEAL RAMIREZ	ALY ANTONIO LEAL RAMIREZ	04145052673	17351083
9836809	9	\N	1	ADELA DAMACIA COLMENAREZ LORETO	ADELA DAMACIA COLMENAREZ LORETO	04168589483	9836809
15308587	9	\N	1	AIDA ROSA DIAZ BARCO	AIDA ROSA DIAZ BARCO	04245394025	15308587
11490301	9	\N	1	LORENZA DEL CARMEN CRIOLLO NARVAEZ	LORENZA DEL CARMEN CRIOLLO NARVAEZ	04164010764	11490301
15071528	9	\N	1	FRANKLIN YANDER PEREZ	FRANKLIN YANDER PEREZ	04261593929	15071528
24616811	9	\N	1	MARILIN DEL CARMEN VALERO PERAZA	MARILIN DEL CARMEN VALERO PERAZA	04168590788	24616811
8065624	9	\N	1	SILVIA DEL CARMEN DUQUE BURGUERA	SILVIA DEL CARMEN DUQUE BURGUERA	04269207156	8065624
17880351	9	\N	1	JOSE ANTONIO GIL RODRIGUEZ	JOSE ANTONIO GIL RODRIGUEZ	04143517814	17880351
17260549	9	\N	1	ISAIRA DEL CARMEN MARQUEZ ORTIZ	ISAIRA DEL CARMEN MARQUEZ ORTIZ	04125085340	17260549
10058701	9	\N	1	MARIA TOMASA ALVARADO COLMENARES	MARIA TOMASA ALVARADO COLMENARES	04264597966	10058701
5130990	9	\N	1	RAFAEL ANGEL GONZALEZ	RAFAEL ANGEL GONZALEZ	04161568832	5130990
11402514	9	\N	1	YADIRA GREGORIA BRICEÑO	YADIRA GREGORIA BRICEÑO	04268391233	11402514
20318152	9	\N	1	ALFREDO ALEJANDRO PERDOMO CHINCHILLA	ALFREDO ALEJANDRO PERDOMO CHINCHILLA	04167430982	20318152
4239772	9	\N	1	PROSPERO JOSE MONTES	PROSPERO JOSE MONTES	04245072565	4239772
10050726	9	\N	1	SANDRA YELITZA SANCHEZ DESANTIAGO	SANDRA YELITZA SANCHEZ DESANTIAGO	04245101509	10050726
9402281	9	\N	1	AUXILIADORA JOSEFINA MELENDEZ VILLEGAS	AUXILIADORA JOSEFINA MELENDEZ VILLEGAS	04125265139	9402281
16415726	9	\N	1	MAYLUN MAGDALENA TORREALBA ALVARADO	MAYLUN MAGDALENA TORREALBA ALVARADO	04165541266	16415726
6680741	9	\N	1	EDILIO ANTONIO GARCIA	EDILIO ANTONIO GARCIA	04165504462	6680741
6294081	9	\N	1	JEANETTE VILLALBA	JEANETTE VILLALBA	04260362453	6294081
19533923	9	\N	1	SAMUEL ALEJANDRO MATUTE MONTOYA	SAMUEL ALEJANDRO MATUTE MONTOYA	04169560825	19533923
22094760	9	\N	1	NERYS DEL CARMEN RAMOS COLMENAREZ	NERYS DEL CARMEN RAMOS COLMENAREZ	04263549247	22094760
19185404	9	\N	1	PASTOR ANTONIO RAMOS	PASTOR ANTONIO RAMOS	04161335368	19185404
16210161	9	\N	1	AUDELIS DE JESUS MARQUEZ CANELON	AUDELIS DE JESUS MARQUEZ CANELON	04166503826	16210161
8058051	9	\N	1	MARIA DEL CARMEN LOYO DE MOLINA	MARIA DEL CARMEN LOYO DE MOLINA	04163581059	8058051
8059488	9	\N	1	LUIS DE BENEDITTE HERNANDEZ	LUIS DE BENEDITTE HERNANDEZ	04169578796	8059488
12238560	9	\N	1	ELIO ANTONIO PERAZA JIMENEZ	ELIO ANTONIO PERAZA JIMENEZ	04266550273	12238560
13991036	9	\N	1	ERIKA BEATRIZ PRADO MARTINEZ	ERIKA BEATRIZ PRADO MARTINEZ	04245030400	13991036
15906362	9	\N	1	MARIA ANTONIA ARROYO GONZALEZ	MARIA ANTONIA ARROYO GONZALEZ	04245718768	15906362
13960278	9	\N	1	GUSTAVO ENRIQUE LOZADA GRATEROL	GUSTAVO ENRIQUE LOZADA GRATEROL	04262707102	13960278
12241365	9	\N	1	MARIA EUFEMIA OBISPO RANGEL	MARIA EUFEMIA OBISPO RANGEL	04168568267	12241365
25424477	9	\N	1	ROCCELY COROMOTO BASTIDAS GRIMAN	ROCCELY COROMOTO BASTIDAS GRIMAN	04163509047	25424477
16291257	9	\N	1	AUDITH CECILIA BARRIOS PADILLA	AUDITH CECILIA BARRIOS PADILLA	04265102351	16291257
12646495	9	\N	1	JOSE TORIBIO SILVA AGUILAR	JOSE TORIBIO SILVA AGUILAR	04264366828	12646495
5129109	9	\N	1	MARIA CONSOLACION BRICEÑO DE FRIAS	MARIA CONSOLACION BRICEÑO DE FRIAS	04267398580	5129109
21160824	9	\N	1	YILEIMI MARIA AGUILAR HIDALGO	YILEIMI MARIA AGUILAR HIDALGO	04126771531	21160824
13330818	9	\N	1	RIOLSI MARIA GONZALEZ SILVA	RIOLSI MARIA GONZALEZ SILVA	04125265958	13330818
19528602	9	\N	1	ZULEIMA MARIELBIS RIVAS	ZULEIMA MARIELBIS RIVAS	2573112626	19528602
9254122	9	\N	1	GLADYS VALERA	GLADYS VALERA	04145370413	9254122
10724019	9	\N	1	ONEIDA MARINA MEJIAS	ONEIDA MARINA MEJIAS	04162162108	10724019
18668508	9	\N	1	YENIFER CAROLINA PEREZ COLMENAREZ	YENIFER CAROLINA PEREZ COLMENAREZ	04145078059	18668508
18472944	9	\N	1	DILIA DEL CARMEN CORTEZ CASTILLO	DILIA DEL CARMEN CORTEZ CASTILLO	04264510590	18472944
17881132	9	\N	1	ADRIANA NEFERTITI PICO HERNANDEZ	ADRIANA NEFERTITI PICO HERNANDEZ	04169505094	17881132
12646445	9	\N	1	LUIS RAMON PERAZA JIMENEZ	LUIS RAMON PERAZA JIMENEZ	04266502096	12646445
12114548	9	\N	1	MARIA ARACELIS MORON DE SANCHEZ	MARIA ARACELIS MORON DE SANCHEZ	04168558435	12114548
9153080	9	\N	1	JOSE DE LA TRINIDAD CONTRERAS VIERA	JOSE DE LA TRINIDAD CONTRERAS VIERA	04163542591	9153080
20544262	9	\N	1	JHONATAN JOSE ALVARADO CASTILLO	JHONATAN JOSE ALVARADO CASTILLO	04162792768	20544262
12008804	9	\N	1	EDGAR JOSE OVIEDO NOGUERA	EDGAR JOSE OVIEDO NOGUERA	04160574344	12008804
15308985	9	\N	1	NOIDI DIAZ ZERPA	NOIDI DIAZ ZERPA	04168584862	15308985
18101622	9	\N	1	LUIS HORACIO LEON MEJIAS	LUIS HORACIO LEON MEJIAS	04167532264	18101622
9403423	9	\N	1	BENEDICTA QUINTERO	BENEDICTA QUINTERO	04247428267	9403423
12648497	9	\N	1	EUGENIA COROMOTO MONTILLA MONTILLA	EUGENIA COROMOTO MONTILLA MONTILLA	04269582887	12648497
16210067	9	\N	1	MARIA EUGENIA CORDERO	MARIA EUGENIA CORDERO	2572515580	16210067
26811990	9	\N	1	LILISBETH COROMOTO GAMEZ GARCIA	LILISBETH COROMOTO GAMEZ GARCIA	04145237424	26811990
4064007	9	\N	1	JOSE SANTANA GUTIERREZ MEDINA	JOSE SANTANA GUTIERREZ MEDINA	04125080956	4064007
15138795	9	\N	1	CECILIO ANTONIO RODRIGUEZ GONZALEZ	CECILIO ANTONIO RODRIGUEZ GONZALEZ	04163520794	15138795
17618377	9	\N	1	JEAN CARLOS DAZA LUQUE	JEAN CARLOS DAZA LUQUE	04168524049	17618377
9405569	9	\N	1	YANET CAROLINA PEREZ	YANET CAROLINA PEREZ	2573953651	9405569
10722071	9	\N	1	JOSE ROSARIO LUQUE SEGURA	JOSE ROSARIO LUQUE SEGURA	04263043337	10722071
17617219	9	\N	1	MARIA ANTONIA RAMOS	MARIA ANTONIA RAMOS	04167552264	17617219
10726013	9	\N	1	SANTO DOROTEO SOTO	SANTO DOROTEO SOTO	04266649448	10726013
12009607	9	\N	1	JOSE RAFAEL RODRIGUEZ CAMACHO	JOSE RAFAEL RODRIGUEZ CAMACHO	04163553410	12009607
22092160	9	\N	1	ELI SAUL SANCHEZ MONTILLA	ELI SAUL SANCHEZ MONTILLA	04125223885	22092160
25256441	9	\N	1	DAYANA DEL CARMEN PIÑA DOBODUTO	DAYANA DEL CARMEN PIÑA DOBODUTO	04161049277	25256441
10264796	9	\N	1	RAMON LEONIDAS MEJIA DELFIN	RAMON LEONIDAS MEJIA DELFIN	04166513847	10264796
14068677	9	\N	1	NESTOR DE JESUS FERNANDEZ MAMBEL	NESTOR DE JESUS FERNANDEZ MAMBEL	04262513387	14068677
12012165	9	\N	1	AGAPITO ANTONIO DIAZ ORELLANA	AGAPITO ANTONIO DIAZ ORELLANA	04145669725	12012165
25547824	9	\N	1	ADELIS ANTONIO MORENO CACERES	ADELIS ANTONIO MORENO CACERES	04262555081	25547824
15399490	9	\N	1	DILGRIS CAROLINA PIÑA GUEDEZ	DILGRIS CAROLINA PIÑA GUEDEZ	04266292044	15399490
8767877	9	\N	1	RAMON DEL CARMEN JIMENEZ RANGEL	RAMON DEL CARMEN JIMENEZ RANGEL	04267845595	8767877
10725320	9	\N	1	LUIS ANTONIO ARMAO	LUIS ANTONIO ARMAO	04263521626	10725320
15799532	9	\N	1	ANGELINA DEL CARMEN BRACAMONTE	ANGELINA DEL CARMEN BRACAMONTE	04164517034	15799532
11396383	9	\N	1	ARGENIS FERNANDEZ GODOY	ARGENIS FERNANDEZ GODOY	04262528530	11396383
14495703	9	\N	1	CLAUDIA BARRIOS PAREJA	CLAUDIA BARRIOS PAREJA	04120512726	14495703
17617778	9	\N	1	OMAR ANTONIO COLMENAREZ HERNANDEZ	OMAR ANTONIO COLMENAREZ HERNANDEZ	04269570158	17617778
16209523	9	\N	1	DANIEL SEGUNDO RODRIGUEZ OSUNA	DANIEL SEGUNDO RODRIGUEZ OSUNA	04145759243	16209523
11546625	9	\N	1	LILA DEL CARMEN YEPEZ AGUILAR	LILA DEL CARMEN YEPEZ AGUILAR	04167359342	11546625
11404475	9	\N	1	JOSE SIMON MORA JIMENEZ	JOSE SIMON MORA JIMENEZ	04263004288	11404475
18095039	9	\N	1	JOSE ALCIRO MACIAS DELGADO	JOSE ALCIRO MACIAS DELGADO	04264572909	18095039
13738805	9	\N	1	LISBETH TIBISAY BENITEZ BENITEZ	LISBETH TIBISAY BENITEZ BENITEZ	04261087026	13738805
12236258	9	\N	1	LUIS BELTRAN LUCENA VELASQUEZ	LUIS BELTRAN LUCENA VELASQUEZ	04149737337	12236258
8054842	9	\N	1	RAFAEL JOSE TORO ROJAS	RAFAEL JOSE TORO ROJAS	04145034894	8054842
6428480	9	\N	1	HAIDEE MARIA MUÑOZ	HAIDEE MARIA MUÑOZ	04145204075	6428480
14995701	9	\N	1	TERESA DEL CARMEN CONTRERAS BRICEÑO	TERESA DEL CARMEN CONTRERAS BRICEÑO	04264360545	14995701
19185144	9	\N	1	LENNYS ANTONIO RAMOS	LENNYS ANTONIO RAMOS	04145679632	19185144
12238602	9	\N	1	ERNESTO ANTONIO PEREZ MORA	ERNESTO ANTONIO PEREZ MORA	04264550112	12238602
21161167	9	\N	1	MAIKELLY CELIMAR MONTILLA UTRIZ	MAIKELLY CELIMAR MONTILLA UTRIZ	04169830300	21161167
21161606	9	\N	1	JOSE MANUEL ANGULO ANGULO	JOSE MANUEL ANGULO ANGULO	04268356508	21161606
5131750	9	\N	1	ZOLANDA COLMENARES COLMENARES	ZOLANDA COLMENARES COLMENARES	2578088795	5131750
25256130	9	\N	1	ALIRIO ANTONIO TORRES LOPEZ	ALIRIO ANTONIO TORRES LOPEZ	04263573662	25256130
15138391	9	\N	1	GIOVANNY COROMOTO INFANTE VASQUEZ	GIOVANNY COROMOTO INFANTE VASQUEZ	04165590195	15138391
5131658	9	\N	1	LIRIA ANTONIA TORRES FRANCO	LIRIA ANTONIA TORRES FRANCO	04167570602	5131658
14570655	9	\N	1	PEDRO JOSE CHINCHILLA GUEDEZ	PEDRO JOSE CHINCHILLA GUEDEZ	04145628780	14570655
24615586	9	\N	1	HILDA MARISELA VILLAMIZAR AGUERO	HILDA MARISELA VILLAMIZAR AGUERO	04169564280	24615586
20543006	9	\N	1	DAIRY DEL CARMEN PEREZ COLMENAREZ	DAIRY DEL CARMEN PEREZ COLMENAREZ	04168538632	20543006
27220917	9	\N	1	NOEL JOSE RODRIGUEZ GUEDEZ	NOEL JOSE RODRIGUEZ GUEDEZ	04266354300	27220917
4359480	9	\N	1	IRMA YOLANDA TORREALBA MUÑOZ	IRMA YOLANDA TORREALBA MUÑOZ	04167573584	4359480
5666129	9	\N	1	LUIS ALBERTO CORREDOR GARCIA	LUIS ALBERTO CORREDOR GARCIA	04162589733	5666129
21526604	9	\N	1	MARBELYS DEL CARMEN AGUILAR ALVARADO	MARBELYS DEL CARMEN AGUILAR ALVARADO	04263506896	21526604
7064453	9	\N	1	LUISA DEL CARMEN RODRIGUEZ YEPEZ	LUISA DEL CARMEN RODRIGUEZ YEPEZ	04164158959	7064453
25285390	9	\N	1	MARIA JANEXIS APONTE OCHOA	MARIA JANEXIS APONTE OCHOA	04263518386	25285390
13738514	9	\N	1	YOLEIDA JOSEFINA DUEÑO MORILLO	YOLEIDA JOSEFINA DUEÑO MORILLO	04145000923	13738514
13604615	9	\N	1	JOSE GREGORIO MONTILLA GARCIA	JOSE GREGORIO MONTILLA GARCIA	04145411390	13604615
14183392	9	\N	1	YERIKA ARACELIS ZERPA	YERIKA ARACELIS ZERPA	04261772913	14183392
20544732	9	\N	1	ENRIQUE ALEXANDER ACEVEDO PEÑARANDA	ENRIQUE ALEXANDER ACEVEDO PEÑARANDA	04245892060	20544732
8056059	9	\N	1	OCTAVIO JOSE LOPEZ	OCTAVIO JOSE LOPEZ	04145451919	8056059
12646789	9	\N	1	ALDO MIRANDA HERNANDEZ	ALDO MIRANDA HERNANDEZ	04265534545	12646789
11404296	9	\N	1	ROSA YENITZA TAPIA DELGADO	ROSA YENITZA TAPIA DELGADO	04161562294	11404296
13040607	9	\N	1	MIRAIMA YALISETH DURAN CANELON	MIRAIMA YALISETH DURAN CANELON	268877680	13040607
20543326	9	\N	1	JOSE GREGORIO RAMOS PAREDES	JOSE GREGORIO RAMOS PAREDES	04165542570	20543326
22902896	9	\N	1	ANA CARMENZA SANTIAGO MORENO	ANA CARMENZA SANTIAGO MORENO	04245605927	22902896
10054544	9	\N	1	JOSE ENRIQUE ALVAREZ	JOSE ENRIQUE ALVAREZ	04269503072	10054544
15881080	9	\N	1	YETZY LILIANA CAMARGO USECHE	YETZY LILIANA CAMARGO USECHE	04145470974	15881080
23049161	9	\N	1	JUAN CARLOS PEREZ BETANCOURT	JUAN CARLOS PEREZ BETANCOURT	04269559459	23049161
15905379	9	\N	1	MARIA ALEJANDRA LOPEZ QUEVEDO	MARIA ALEJANDRA LOPEZ QUEVEDO	04263701677	15905379
8052995	9	\N	1	ROGELIO ANTONIO PEREZ SILVA	ROGELIO ANTONIO PEREZ SILVA	04261529242	8052995
9917485	9	\N	1	LUIS ALEXANDER SANCHEZ MONTENGRO	LUIS ALEXANDER SANCHEZ MONTENGRO	04245800168	9917485
16645425	9	\N	1	NELLY MARIA GIMENEZ RODRIGUEZ	NELLY MARIA GIMENEZ RODRIGUEZ	04263536281	16645425
15798314	9	\N	1	OMAR ANTONIO PEREZ GARRIDO	OMAR ANTONIO PEREZ GARRIDO	04169503205	15798314
18669993	9	\N	1	MARIA GABRIELA GORDILLO MONTES	MARIA GABRIELA GORDILLO MONTES	04125188388	18669993
24908100	9	\N	1	ENMANUEL JOSUE MORILLO ANTEQUERA	ENMANUEL JOSUE MORILLO ANTEQUERA	04163593192	24908100
22094579	9	\N	1	WILLIAN RAMON LINAREZ COLMENAREZ	WILLIAN RAMON LINAREZ COLMENAREZ	04245909239	22094579
9366506	9	\N	1	ANA ROSA HERNANDEZ AYALA	ANA ROSA HERNANDEZ AYALA	04141440076	9366506
8060149	9	\N	1	JOSE AGUSTIN ARROYO	JOSE AGUSTIN ARROYO	04169969879	8060149
20225608	9	\N	1	JESUS DANIEL MORA CONTRERAS	JESUS DANIEL MORA CONTRERAS	04125354859	20225608
22094752	9	\N	1	GEREMIAS ANTONIO LOPEZ PIÑERO	GEREMIAS ANTONIO LOPEZ PIÑERO	04166544660	22094752
7466120	9	\N	1	FLORIPE ANTONIO RODRIGUEZ LOPEZ	FLORIPE ANTONIO RODRIGUEZ LOPEZ	04125108318	7466120
14002468	9	\N	1	NELSON LEONARDO COLMENARES PEÑA	NELSON LEONARDO COLMENARES PEÑA	04164510828	14002468
15309883	9	\N	1	JOSE GIOVANNY REINOSO CARRERO	JOSE GIOVANNY REINOSO CARRERO	04167538429	15309883
9090799	9	\N	1	JUANA FRANCISCA QUEVEDO DE TORRES	JUANA FRANCISCA QUEVEDO DE TORRES	04145562272	9090799
13313525	9	\N	1	GREDDY YAMILETH GIMENEZ MONSALVE	GREDDY YAMILETH GIMENEZ MONSALVE	04245327055	13313525
15905905	9	\N	1	OLEANNY MILEIDY VALERA CAMACHO	OLEANNY MILEIDY VALERA CAMACHO	2572561818	15905905
20318866	9	\N	1	MARIA ALEJANDRA FERNANDEZ NOGUERA	MARIA ALEJANDRA FERNANDEZ NOGUERA	04167514588	20318866
10727105	9	\N	1	HONORIO JOSE PIÑA BRICEÑO	HONORIO JOSE PIÑA BRICEÑO	04140546825	10727105
24018978	9	\N	1	WILLIAMS ALFREDO SANCHEZ PEREZ	WILLIAMS ALFREDO SANCHEZ PEREZ	04245859372	24018978
12896345	9	\N	1	ALYLLY CARLOS FERRER BECERRA	ALYLLY CARLOS FERRER BECERRA	04245774074	12896345
14332487	9	\N	1	LISBETH COROMOTO OLIVO RODRIGUEZ	LISBETH COROMOTO OLIVO RODRIGUEZ	04168513865	14332487
7982025	9	\N	1	ELEIDA DEL CARMEN BRITO GUTIERREZ	ELEIDA DEL CARMEN BRITO GUTIERREZ	04169539364	7982025
17003694	9	\N	1	RAFAEL RAINIERO ORELLANA ARRIECHE	RAFAEL RAINIERO ORELLANA ARRIECHE	04245017343	17003694
14467477	9	\N	1	JOHNNY COROMOTO PEREZ HIDALGO	JOHNNY COROMOTO PEREZ HIDALGO	04168536122	14467477
11401202	9	\N	1	YUDITH FEDAMARIS GARCIAS COLMENARES	YUDITH FEDAMARIS GARCIAS COLMENARES	04163506342	11401202
9400742	9	\N	1	SANDRA COROMOTO TORREALBA RODRIGUEZ	SANDRA COROMOTO TORREALBA RODRIGUEZ	04145774741	9400742
4240311	9	\N	1	GENIA MARGARITA SILVA	GENIA MARGARITA SILVA	04265509696	04240311
10122993	9	\N	1	NICOLAS FLORENTINO RODRIGUEZ COLMENAREZ	NICOLAS FLORENTINO RODRIGUEZ COLMENAREZ	04245760344	10122993
12236517	9	\N	1	GUSTAVO ADOLFO ROJAS MORA	GUSTAVO ADOLFO ROJAS MORA	04166566906	12236517
4240025	9	\N	1	MARIA CLEMENTINA SERENO	MARIA CLEMENTINA SERENO	2572561904	04240025
20317558	9	\N	1	ANA REVECA NIETO QUIÑONEZ	ANA REVECA NIETO QUIÑONEZ	04269621578	20317558
10726419	9	\N	1	ROSA RAQUEL ALVARADO	ROSA RAQUEL ALVARADO	04145357162	10726419
25256173	9	\N	1	ENDER JOSE GIL SALAZAR	ENDER JOSE GIL SALAZAR	04161533934	25256173
26075300	9	\N	1	ROSA ANGELICA RANGEL FERNANDEZ	ROSA ANGELICA RANGEL FERNANDEZ	04267080762	26075300
\.


--
-- Data for Name: outbox; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY outbox ("UpdatedInDB", "InsertIntoDB", "SendingDateTime", "SendBefore", "SendAfter", "Text", "DestinationNumber", "Coding", "UDH", "Class", "TextDecoded", "ID", "MultiPart", "RelativeValidity", "SenderID", "SendingTimeOut", "DeliveryReport", "CreatorID", "Retries", "Priority") FROM stdin;
2017-09-20 23:38:06	2017-09-20 23:38:06	2017-09-20 23:38:06	23:59:59	00:00:00	\N	04145049212	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 1	8	f	-1	\N	2017-09-20 23:38:06	default	Tabadek	0	0
2017-09-20 23:41:46	2017-09-20 23:41:46	2017-09-20 23:41:46	23:59:59	00:00:00	\N	04163548073	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 2	9	f	-1	\N	2017-09-20 23:41:46	default	admin	0	0
2017-09-20 23:44:25	2017-09-20 23:44:25	2017-09-20 23:44:25	23:59:59	00:00:00	\N	04128516440	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 3	10	f	-1	\N	2017-09-20 23:44:25	default	Tabadek	0	0
2017-09-20 23:47:46	2017-09-20 23:47:46	2017-09-20 23:47:46	23:59:59	00:00:00	\N	04149530930	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 4	11	f	-1	\N	2017-09-20 23:47:46	default	manuel	0	0
2017-09-20 23:51:58	2017-09-20 23:51:58	2017-09-20 23:51:58	23:59:59	00:00:00	\N	04245709799	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 5	12	f	-1	\N	2017-09-20 23:51:58	default	Tabadek	0	0
2017-09-20 23:53:38	2017-09-20 23:53:38	2017-09-20 23:53:38	23:59:59	00:00:00	\N	04145740974	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 6	13	f	-1	\N	2017-09-20 23:53:38	default	admin	0	0
2017-09-20 23:56:11	2017-09-20 23:56:11	2017-09-20 23:56:11	23:59:59	00:00:00	\N	04267373951	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 7	14	f	-1	\N	2017-09-20 23:56:11	default	Tabadek	0	0
2017-09-20 23:58:18	2017-09-20 23:58:18	2017-09-20 23:58:18	23:59:59	00:00:00	\N	04263565424	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 8	15	f	-1	\N	2017-09-20 23:58:18	default	manuel	0	0
2017-09-21 00:02:17	2017-09-21 00:02:17	2017-09-21 00:02:17	23:59:59	00:00:00	\N	04268529907	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 9	16	f	-1	\N	2017-09-21 00:02:17	default	Tabadek	0	0
2017-09-21 00:03:03	2017-09-21 00:03:03	2017-09-21 00:03:03	23:59:59	00:00:00	\N	04161291106	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 10	17	f	-1	\N	2017-09-21 00:03:03	default	admin	0	0
2017-09-21 00:05:32	2017-09-21 00:05:32	2017-09-21 00:05:32	23:59:59	00:00:00	\N	04268500205	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 11	18	f	-1	\N	2017-09-21 00:05:32	default	Tabadek	0	0
2017-09-21 00:09:24	2017-09-21 00:09:24	2017-09-21 00:09:24	23:59:59	00:00:00	\N	04245865103	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12	19	f	-1	\N	2017-09-21 00:09:24	default	Tabadek	0	0
2017-09-21 00:12:49	2017-09-21 00:12:49	2017-09-21 00:12:49	23:59:59	00:00:00	\N	04168183569	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 14	20	f	-1	\N	2017-09-21 00:12:49	default	manuel	0	0
2017-09-21 00:25:38	2017-09-21 00:25:38	2017-09-21 00:25:38	23:59:59	00:00:00	\N	04245531071	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 16	21	f	-1	\N	2017-09-21 00:25:38	default	manuel	0	0
2017-09-21 00:27:53	2017-09-21 00:27:53	2017-09-21 00:27:53	23:59:59	00:00:00	\N	04169267788	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 18	22	f	-1	\N	2017-09-21 00:27:53	default	Tabadek	0	0
2017-09-21 00:35:05	2017-09-21 00:35:05	2017-09-21 00:35:05	23:59:59	00:00:00	\N	04160000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 19	23	f	-1	\N	2017-09-21 00:35:05	default	manuel	0	0
2017-09-21 00:35:35	2017-09-21 00:35:35	2017-09-21 00:35:35	23:59:59	00:00:00	\N	04266517351	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 20	24	f	-1	\N	2017-09-21 00:35:35	default	admin	0	0
2017-09-21 00:44:14	2017-09-21 00:44:14	2017-09-21 00:44:14	23:59:59	00:00:00	\N	04144057995	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 21	25	f	-1	\N	2017-09-21 00:44:14	default	Tabadek	0	0
2017-09-21 00:44:43	2017-09-21 00:44:43	2017-09-21 00:44:43	23:59:59	00:00:00	\N	04263184606	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 22	26	f	-1	\N	2017-09-21 00:44:43	default	admin	0	0
2017-09-21 00:53:07	2017-09-21 00:53:07	2017-09-21 00:53:07	23:59:59	00:00:00	\N	04165384027	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 23	27	f	-1	\N	2017-09-21 00:53:07	default	Tabadek	0	0
2017-09-21 00:54:20	2017-09-21 00:54:20	2017-09-21 00:54:20	23:59:59	00:00:00	\N	04140000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 25	28	f	-1	\N	2017-09-21 00:54:20	default	manuel	0	0
2017-09-21 00:54:24	2017-09-21 00:54:24	2017-09-21 00:54:24	23:59:59	00:00:00	\N	04165384027	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 26	29	f	-1	\N	2017-09-21 00:54:24	default	Tabadek	0	0
2017-09-21 01:01:49	2017-09-21 01:01:49	2017-09-21 01:01:49	23:59:59	00:00:00	\N	04144442442	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 28	30	f	-1	\N	2017-09-21 01:01:49	default	Tabadek	0	0
2017-09-21 01:08:24	2017-09-21 01:08:24	2017-09-21 01:08:24	23:59:59	00:00:00	\N	04140572328	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 29	31	f	-1	\N	2017-09-21 01:08:24	default	admin	0	0
2017-09-21 01:11:17	2017-09-21 01:11:17	2017-09-21 01:11:17	23:59:59	00:00:00	\N	04145348464	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 30	32	f	-1	\N	2017-09-21 01:11:17	default	Tabadek	0	0
2017-09-21 01:21:49	2017-09-21 01:21:49	2017-09-21 01:21:49	23:59:59	00:00:00	\N	04145348464	Default_No_Compression	\N	-1	@rafaelcalles: Su Solicitud Fue CANCELADA, Para Mas Información Consulte su ticket por Internet o Visite Nuestras Oficinas.; Ticket Nro.: 30	33	f	-1	\N	2017-09-21 01:21:49	default	Tabadek	0	0
2017-09-21 01:23:33	2017-09-21 01:23:33	2017-09-21 01:23:33	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 31	34	f	-1	\N	2017-09-21 01:23:33	default	admin	0	0
2017-09-21 01:24:58	2017-09-21 01:24:58	2017-09-21 01:24:58	23:59:59	00:00:00	\N	04145348464	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 32	35	f	-1	\N	2017-09-21 01:24:58	default	Tabadek	0	0
2017-09-21 01:25:05	2017-09-21 01:25:05	2017-09-21 01:25:05	23:59:59	00:00:00	\N	04145348464	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 33	36	f	-1	\N	2017-09-21 01:25:05	default	Tabadek	0	0
2017-09-21 01:30:54	2017-09-21 01:30:54	2017-09-21 01:30:54	23:59:59	00:00:00	\N	04144422302	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 34	37	f	-1	\N	2017-09-21 01:30:54	default	Tabadek	0	0
2017-09-21 01:35:34	2017-09-21 01:35:34	2017-09-21 01:35:34	23:59:59	00:00:00	\N	04262519802	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 35	38	f	-1	\N	2017-09-21 01:35:34	default	manuel	0	0
2017-09-21 01:38:03	2017-09-21 01:38:03	2017-09-21 01:38:03	23:59:59	00:00:00	\N	04144124124	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 36	39	f	-1	\N	2017-09-21 01:38:03	default	Tabadek	0	0
2017-09-21 01:45:33	2017-09-21 01:45:33	2017-09-21 01:45:33	23:59:59	00:00:00	\N	04145508267	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 37	40	f	-1	\N	2017-09-21 01:45:33	default	manuel	0	0
2017-09-21 01:53:28	2017-09-21 01:53:28	2017-09-21 01:53:28	23:59:59	00:00:00	\N	04263371975	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 38	41	f	-1	\N	2017-09-21 01:53:28	default	admin	0	0
2017-09-21 01:55:09	2017-09-21 01:55:09	2017-09-21 01:55:09	23:59:59	00:00:00	\N	04160000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 39	42	f	-1	\N	2017-09-21 01:55:09	default	manuel	0	0
2017-09-21 01:56:04	2017-09-21 01:56:04	2017-09-21 01:56:04	23:59:59	00:00:00	\N	04263371975	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 40	43	f	-1	\N	2017-09-21 01:56:04	default	admin	0	0
2017-09-21 02:06:08	2017-09-21 02:06:08	2017-09-21 02:06:08	23:59:59	00:00:00	\N	04160000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 41	44	f	-1	\N	2017-09-21 02:06:08	default	manuel	0	0
2017-09-21 02:10:24	2017-09-21 02:10:24	2017-09-21 02:10:24	23:59:59	00:00:00	\N	04160000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 42	45	f	-1	\N	2017-09-21 02:10:24	default	manuel	0	0
2017-09-21 02:12:49	2017-09-21 02:12:49	2017-09-21 02:12:49	23:59:59	00:00:00	\N	04269526977	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 43	46	f	-1	\N	2017-09-21 02:12:49	default	admin	0	0
2017-09-21 02:13:08	2017-09-21 02:13:08	2017-09-21 02:13:08	23:59:59	00:00:00	\N	04160000000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 44	47	f	-1	\N	2017-09-21 02:13:08	default	manuel	0	0
2017-09-21 02:22:30	2017-09-21 02:22:30	2017-09-21 02:22:30	23:59:59	00:00:00	\N	04245503633	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 45	48	f	-1	\N	2017-09-21 02:22:30	default	admin	0	0
2017-09-21 02:26:54	2017-09-21 02:26:54	2017-09-21 02:26:54	23:59:59	00:00:00	\N	04124124123	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 46	49	f	-1	\N	2017-09-21 02:26:54	default	Tabadek	0	0
2017-09-21 02:29:05	2017-09-21 02:29:05	2017-09-21 02:29:05	23:59:59	00:00:00	\N	04145581919	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 47	50	f	-1	\N	2017-09-21 02:29:05	default	manuel	0	0
2017-09-21 02:31:58	2017-09-21 02:31:58	2017-09-21 02:31:58	23:59:59	00:00:00	\N	04267528004	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 49	51	f	-1	\N	2017-09-21 02:31:58	default	Tabadek	0	0
2017-09-21 02:37:30	2017-09-21 02:37:30	2017-09-21 02:37:30	23:59:59	00:00:00	\N	04144123212	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 50	52	f	-1	\N	2017-09-21 02:37:30	default	Tabadek	0	0
2017-09-21 02:39:06	2017-09-21 02:39:06	2017-09-21 02:39:06	23:59:59	00:00:00	\N	04165555555	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 51	53	f	-1	\N	2017-09-21 02:39:06	default	manuel	0	0
2017-09-21 02:39:39	2017-09-21 02:39:39	2017-09-21 02:39:39	23:59:59	00:00:00	\N	04165384027	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 53	54	f	-1	\N	2017-09-21 02:39:39	default	Tabadek	0	0
2017-09-21 02:49:27	2017-09-21 02:49:27	2017-09-21 02:49:27	23:59:59	00:00:00	\N	04161785272	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 54	55	f	-1	\N	2017-09-21 02:49:27	default	Tabadek	0	0
2017-09-21 02:50:34	2017-09-21 02:50:34	2017-09-21 02:50:34	23:59:59	00:00:00	\N	04161785272	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 55	56	f	-1	\N	2017-09-21 02:50:34	default	Tabadek	0	0
2017-09-21 02:51:53	2017-09-21 02:51:53	2017-09-21 02:51:53	23:59:59	00:00:00	\N	04161785272	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 56	57	f	-1	\N	2017-09-21 02:51:53	default	Tabadek	0	0
2017-09-21 02:56:14	2017-09-21 02:56:14	2017-09-21 02:56:14	23:59:59	00:00:00	\N	04167192837	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 57	58	f	-1	\N	2017-09-21 02:56:14	default	Tabadek	0	0
2017-09-21 02:58:54	2017-09-21 02:58:54	2017-09-21 02:58:54	23:59:59	00:00:00	\N	04164560553	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 58	59	f	-1	\N	2017-09-21 02:58:54	default	Tabadek	0	0
2017-09-21 08:27:08	2017-09-21 08:27:08	2017-09-21 08:27:08	23:59:59	00:00:00	\N	04245013163	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12001	60	f	-1	\N	2017-09-21 08:27:08	default	Olarmelina	0	0
2017-09-21 08:37:24	2017-09-21 08:37:24	2017-09-21 08:37:24	23:59:59	00:00:00	\N	04167776633	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12002	61	f	-1	\N	2017-09-21 08:37:24	default	griselda	0	0
2017-09-21 08:47:58	2017-09-21 08:47:58	2017-09-21 08:47:58	23:59:59	00:00:00	\N	04162575831	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12003	62	f	-1	\N	2017-09-21 08:47:58	default	douglasr	0	0
2017-09-21 09:30:05	2017-09-21 09:30:05	2017-09-21 09:30:05	23:59:59	00:00:00	\N	04145119926	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12004	63	f	-1	\N	2017-09-21 09:30:05	default	jrangel	0	0
2017-09-21 09:32:18	2017-09-21 09:32:18	2017-09-21 09:32:18	23:59:59	00:00:00	\N	04265034479	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12005	64	f	-1	\N	2017-09-21 09:32:18	default	douglasr	0	0
2017-09-21 09:33:45	2017-09-21 09:33:45	2017-09-21 09:33:45	23:59:59	00:00:00	\N	04145119926	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12006	65	f	-1	\N	2017-09-21 09:33:45	default	jrangel	0	0
2017-09-21 09:47:28	2017-09-21 09:47:28	2017-09-21 09:47:28	23:59:59	00:00:00	\N	04245641479	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12007	66	f	-1	\N	2017-09-21 09:47:28	default	Olarmelina	0	0
2017-09-21 10:12:20	2017-09-21 10:12:20	2017-09-21 10:12:20	23:59:59	00:00:00	\N	04164076604	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12009	67	f	-1	\N	2017-09-21 10:12:20	default	jrangel	0	0
2017-09-21 10:35:53	2017-09-21 10:35:53	2017-09-21 10:35:53	23:59:59	00:00:00	\N	04266510141	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12010	68	f	-1	\N	2017-09-21 10:35:53	default	Olarmelina	0	0
2017-09-21 10:55:44	2017-09-21 10:55:44	2017-09-21 10:55:44	23:59:59	00:00:00	\N	04140359081	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12011	69	f	-1	\N	2017-09-21 10:55:44	default	douglasr	0	0
2017-09-21 11:10:09	2017-09-21 11:10:09	2017-09-21 11:10:09	23:59:59	00:00:00	\N	04161776858	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12012	70	f	-1	\N	2017-09-21 11:10:09	default	Olarmelina	0	0
2017-09-21 11:26:37	2017-09-21 11:26:37	2017-09-21 11:26:37	23:59:59	00:00:00	\N	04161528405	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12013	71	f	-1	\N	2017-09-21 11:26:37	default	Olarmelina	0	0
2017-09-21 14:00:18	2017-09-21 14:00:18	2017-09-21 14:00:18	23:59:59	00:00:00	\N	04163549120	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12014	72	f	-1	\N	2017-09-21 14:00:18	default	jrangel	0	0
2017-09-21 14:33:44	2017-09-21 14:33:44	2017-09-21 14:33:44	23:59:59	00:00:00	\N	04262548420	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12015	73	f	-1	\N	2017-09-21 14:33:44	default	douglasr	0	0
2017-09-21 14:56:19	2017-09-21 14:56:19	2017-09-21 14:56:19	23:59:59	00:00:00	\N	04161266740	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12016	74	f	-1	\N	2017-09-21 14:56:19	default	Olarmelina	0	0
2017-09-21 15:08:32	2017-09-21 15:08:32	2017-09-21 15:08:32	23:59:59	00:00:00	\N	04245998750	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12017	75	f	-1	\N	2017-09-21 15:08:32	default	Olarmelina	0	0
2017-09-21 15:17:48	2017-09-21 15:17:48	2017-09-21 15:17:48	23:59:59	00:00:00	\N	04245032553	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12018	76	f	-1	\N	2017-09-21 15:17:48	default	Olarmelina	0	0
2017-09-21 15:28:37	2017-09-21 15:28:37	2017-09-21 15:28:37	23:59:59	00:00:00	\N	04243364468	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12019	77	f	-1	\N	2017-09-21 15:28:37	default	Olarmelina	0	0
2017-09-21 16:18:11	2017-09-21 16:18:11	2017-09-21 16:18:11	23:59:59	00:00:00	\N	04126783464	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12020	78	f	-1	\N	2017-09-21 16:18:11	default	Olarmelina	0	0
2017-09-21 16:20:57	2017-09-21 16:20:57	2017-09-21 16:20:57	23:59:59	00:00:00	\N	04168586085	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12021	79	f	-1	\N	2017-09-21 16:20:57	default	douglasr	0	0
2017-09-22 08:47:37	2017-09-22 08:47:37	2017-09-22 08:47:37	23:59:59	00:00:00	\N	04163587622	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12022	80	f	-1	\N	2017-09-22 08:47:37	default	Olarmelina	0	0
2017-09-22 08:47:38	2017-09-22 08:47:38	2017-09-22 08:47:38	23:59:59	00:00:00	\N	04163587622	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12023	81	f	-1	\N	2017-09-22 08:47:38	default	Olarmelina	0	0
2017-09-22 09:16:13	2017-09-22 09:16:13	2017-09-22 09:16:13	23:59:59	00:00:00	\N	04261577167	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12024	82	f	-1	\N	2017-09-22 09:16:13	default	Olarmelina	0	0
2017-09-22 09:17:47	2017-09-22 09:17:47	2017-09-22 09:17:47	23:59:59	00:00:00	\N	04167776154	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12025	83	f	-1	\N	2017-09-22 09:17:47	default	douglasr	0	0
2017-09-22 09:31:51	2017-09-22 09:31:51	2017-09-22 09:31:51	23:59:59	00:00:00	\N	04162513294	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12026	84	f	-1	\N	2017-09-22 09:31:51	default	Olarmelina	0	0
2017-09-22 09:42:10	2017-09-22 09:42:10	2017-09-22 09:42:10	23:59:59	00:00:00	\N	04269739226	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12027	85	f	-1	\N	2017-09-22 09:42:10	default	griselda	0	0
2017-09-22 09:49:12	2017-09-22 09:49:12	2017-09-22 09:49:12	23:59:59	00:00:00	\N	04145197667	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 59	86	f	-1	\N	2017-09-22 09:49:12	default	HOSTO.REIMAR	0	0
2017-09-22 09:56:21	2017-09-22 09:56:21	2017-09-22 09:56:21	23:59:59	00:00:00	\N	04266536963	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12028	87	f	-1	\N	2017-09-22 09:56:21	default	jrangel	0	0
2017-09-22 10:10:10	2017-09-22 10:10:10	2017-09-22 10:10:10	23:59:59	00:00:00	\N	04161322393	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12029	88	f	-1	\N	2017-09-22 10:10:10	default	Olarmelina	0	0
2017-09-22 10:29:17	2017-09-22 10:29:17	2017-09-22 10:29:17	23:59:59	00:00:00	\N	04245604859	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12030	89	f	-1	\N	2017-09-22 10:29:17	default	douglasr	0	0
2017-09-22 10:57:32	2017-09-22 10:57:32	2017-09-22 10:57:32	23:59:59	00:00:00	\N	04264472146	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12031	90	f	-1	\N	2017-09-22 10:57:32	default	griselda	0	0
2017-09-22 11:35:06	2017-09-22 11:35:06	2017-09-22 11:35:06	23:59:59	00:00:00	\N	04245581011	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12032	91	f	-1	\N	2017-09-22 11:35:06	default	douglasr	0	0
2017-09-22 11:35:07	2017-09-22 11:35:07	2017-09-22 11:35:07	23:59:59	00:00:00	\N	04245581011	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12033	92	f	-1	\N	2017-09-22 11:35:07	default	douglasr	0	0
2017-09-22 11:35:33	2017-09-22 11:35:33	2017-09-22 11:35:33	23:59:59	00:00:00	\N	04169575594	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 60	93	f	-1	\N	2017-09-22 11:35:33	default	admin	0	0
2017-09-22 11:37:35	2017-09-22 11:37:35	2017-09-22 11:37:35	23:59:59	00:00:00	\N	04245173833	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 61	94	f	-1	\N	2017-09-22 11:37:35	default	EVANS	0	0
2017-09-22 11:48:51	2017-09-22 11:48:51	2017-09-22 11:48:51	23:59:59	00:00:00	\N	04145786615	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 62	95	f	-1	\N	2017-09-22 11:48:51	default	MARYCORDERO	0	0
2017-09-22 11:54:02	2017-09-22 11:54:02	2017-09-22 11:54:02	23:59:59	00:00:00	\N	04245145242	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 63	96	f	-1	\N	2017-09-22 11:54:02	default	edimar	0	0
2017-09-22 11:54:04	2017-09-22 11:54:04	2017-09-22 11:54:04	23:59:59	00:00:00	\N	04261704900	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 64	97	f	-1	\N	2017-09-22 11:54:04	default	GENESISLEON	0	0
2017-09-22 11:56:48	2017-09-22 11:56:48	2017-09-22 11:56:48	23:59:59	00:00:00	\N	04245881476	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12034	98	f	-1	\N	2017-09-22 11:56:48	default	Olarmelina	0	0
2017-09-22 12:00:13	2017-09-22 12:00:13	2017-09-22 12:00:13	23:59:59	00:00:00	\N	04122986868	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 65	99	f	-1	\N	2017-09-22 12:00:13	default	MARIA	0	0
2017-09-22 12:06:13	2017-09-22 12:06:13	2017-09-22 12:06:13	23:59:59	00:00:00	\N	04264502282	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 66	100	f	-1	\N	2017-09-22 12:06:13	default	EVANS	0	0
2017-09-22 12:10:19	2017-09-22 12:10:19	2017-09-22 12:10:19	23:59:59	00:00:00	\N	04122986868	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 67	101	f	-1	\N	2017-09-22 12:10:19	default	MARIA	0	0
2017-09-22 12:12:27	2017-09-22 12:12:27	2017-09-22 12:12:27	23:59:59	00:00:00	\N	04268142178	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 68	102	f	-1	\N	2017-09-22 12:12:27	default	genesis	0	0
2017-09-22 12:27:18	2017-09-22 12:27:18	2017-09-22 12:27:18	23:59:59	00:00:00	\N	04126114023	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 69	103	f	-1	\N	2017-09-22 12:27:18	default	EVANS	0	0
2017-09-22 12:36:26	2017-09-22 12:36:26	2017-09-22 12:36:26	23:59:59	00:00:00	\N	04261704900	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 70	104	f	-1	\N	2017-09-22 12:36:26	default	GENESISLEON	0	0
2017-09-22 12:37:22	2017-09-22 12:37:22	2017-09-22 12:37:22	23:59:59	00:00:00	\N	04261597513	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 71	105	f	-1	\N	2017-09-22 12:37:22	default	EVANS	0	0
2017-09-22 12:41:35	2017-09-22 12:41:35	2017-09-22 12:41:35	23:59:59	00:00:00	\N	04261597513	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 72	106	f	-1	\N	2017-09-22 12:41:35	default	EVANS	0	0
2017-09-22 12:46:18	2017-09-22 12:46:18	2017-09-22 12:46:18	23:59:59	00:00:00	\N	04268142178	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 73	107	f	-1	\N	2017-09-22 12:46:18	default	genesis	0	0
2017-09-22 12:53:47	2017-09-22 12:53:47	2017-09-22 12:53:47	23:59:59	00:00:00	\N	04263080557	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 74	108	f	-1	\N	2017-09-22 12:53:47	default	GENESISLEON	0	0
2017-09-22 13:02:09	2017-09-22 13:02:09	2017-09-22 13:02:09	23:59:59	00:00:00	\N	04120559731	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 75	109	f	-1	\N	2017-09-22 13:02:09	default	EVANS	0	0
2017-09-22 13:10:14	2017-09-22 13:10:14	2017-09-22 13:10:14	23:59:59	00:00:00	\N	04263297788	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 76	110	f	-1	\N	2017-09-22 13:10:14	default	ANGELASOTO	0	0
2017-09-22 13:21:33	2017-09-22 13:21:33	2017-09-22 13:21:33	23:59:59	00:00:00	\N	04263297788	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 77	111	f	-1	\N	2017-09-22 13:21:33	default	ANGELASOTO	0	0
2017-09-22 13:21:33	2017-09-22 13:21:33	2017-09-22 13:21:33	23:59:59	00:00:00	\N	04261079742	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12035	112	f	-1	\N	2017-09-22 13:21:33	default	griselda	0	0
2017-09-22 13:25:47	2017-09-22 13:25:47	2017-09-22 13:25:47	23:59:59	00:00:00	\N	04261079742	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12036	113	f	-1	\N	2017-09-22 13:25:47	default	griselda	0	0
2017-09-22 13:25:53	2017-09-22 13:25:53	2017-09-22 13:25:53	23:59:59	00:00:00	\N	04263297788	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 78	114	f	-1	\N	2017-09-22 13:25:53	default	ANGELASOTO	0	0
2017-09-22 13:29:55	2017-09-22 13:29:55	2017-09-22 13:29:55	23:59:59	00:00:00	\N	04169550869	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 79	115	f	-1	\N	2017-09-22 13:29:55	default	EVANS	0	0
2017-09-22 13:36:16	2017-09-22 13:36:16	2017-09-22 13:36:16	23:59:59	00:00:00	\N	04160505338	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12037	116	f	-1	\N	2017-09-22 13:36:16	default	griselda	0	0
2017-09-22 13:44:40	2017-09-22 13:44:40	2017-09-22 13:44:40	23:59:59	00:00:00	\N	04145244946	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12038	117	f	-1	\N	2017-09-22 13:44:40	default	douglasr	0	0
2017-09-22 13:47:18	2017-09-22 13:47:18	2017-09-22 13:47:18	23:59:59	00:00:00	\N	04262627340	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 82	118	f	-1	\N	2017-09-22 13:47:18	default	MARIA	0	0
2017-09-22 13:50:49	2017-09-22 13:50:49	2017-09-22 13:50:49	23:59:59	00:00:00	\N	04262627340	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 83	119	f	-1	\N	2017-09-22 13:50:49	default	MARIA	0	0
2017-09-22 13:50:56	2017-09-22 13:50:56	2017-09-22 13:50:56	23:59:59	00:00:00	\N	04164285635	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 84	120	f	-1	\N	2017-09-22 13:50:56	default	EVANS	0	0
2017-09-22 13:50:59	2017-09-22 13:50:59	2017-09-22 13:50:59	23:59:59	00:00:00	\N	04263080557	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 85	121	f	-1	\N	2017-09-22 13:50:59	default	ANGELASOTO	0	0
2017-09-22 13:54:13	2017-09-22 13:54:13	2017-09-22 13:54:13	23:59:59	00:00:00	\N	04164285635	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 87	122	f	-1	\N	2017-09-22 13:54:13	default	EVANS	0	0
2017-09-22 14:01:54	2017-09-22 14:01:54	2017-09-22 14:01:54	23:59:59	00:00:00	\N	04145176000	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 88	123	f	-1	\N	2017-09-22 14:01:54	default	MARIA	0	0
2017-09-22 14:04:24	2017-09-22 14:04:24	2017-09-22 14:04:24	23:59:59	00:00:00	\N	04168262241	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 89	124	f	-1	\N	2017-09-22 14:04:24	default	EVANS	0	0
2017-09-22 14:16:48	2017-09-22 14:16:48	2017-09-22 14:16:48	23:59:59	00:00:00	\N	04163154970	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 91	125	f	-1	\N	2017-09-22 14:16:48	default	MARIA	0	0
2017-09-22 14:26:47	2017-09-22 14:26:47	2017-09-22 14:26:47	23:59:59	00:00:00	\N	04261429517	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 92	126	f	-1	\N	2017-09-22 14:26:47	default	ANGELASOTO	0	0
2017-09-22 14:27:15	2017-09-22 14:27:15	2017-09-22 14:27:15	23:59:59	00:00:00	\N	04264552524	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 93	127	f	-1	\N	2017-09-22 14:27:15	default	GENESISLEON	0	0
2017-09-22 14:31:54	2017-09-22 14:31:54	2017-09-22 14:31:54	23:59:59	00:00:00	\N	04261429517	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 94	128	f	-1	\N	2017-09-22 14:31:54	default	ANGELASOTO	0	0
2017-09-22 14:43:13	2017-09-22 14:43:13	2017-09-22 14:43:13	23:59:59	00:00:00	\N	04245591084	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 96	129	f	-1	\N	2017-09-22 14:43:13	default	GENESISLEON	0	0
2017-09-22 14:47:00	2017-09-22 14:47:00	2017-09-22 14:47:00	23:59:59	00:00:00	\N	04269577175	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 99	130	f	-1	\N	2017-09-22 14:47:00	default	ANGELASOTO	0	0
2017-09-22 14:52:49	2017-09-22 14:52:49	2017-09-22 14:52:49	23:59:59	00:00:00	\N	04145786615	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 101	131	f	-1	\N	2017-09-22 14:52:49	default	MARYCORDERO	0	0
2017-09-22 14:53:30	2017-09-22 14:53:30	2017-09-22 14:53:30	23:59:59	00:00:00	\N	04245591084	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 103	132	f	-1	\N	2017-09-22 14:53:30	default	GENESISLEON	0	0
2017-09-22 14:57:45	2017-09-22 14:57:45	2017-09-22 14:57:45	23:59:59	00:00:00	\N	04168571832	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12039	133	f	-1	\N	2017-09-22 14:57:45	default	douglasr	0	0
2017-09-22 15:04:54	2017-09-22 15:04:54	2017-09-22 15:04:54	23:59:59	00:00:00	\N	04264540970	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 105	134	f	-1	\N	2017-09-22 15:04:54	default	ANGELASOTO	0	0
2017-09-22 15:05:13	2017-09-22 15:05:13	2017-09-22 15:05:13	23:59:59	00:00:00	\N	04269563907	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12040	135	f	-1	\N	2017-09-22 15:05:13	default	douglasr	0	0
2017-09-22 15:14:09	2017-09-22 15:14:09	2017-09-22 15:14:09	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 108	136	f	-1	\N	2017-09-22 15:14:09	default	EVANS	0	0
2017-09-22 15:14:55	2017-09-22 15:14:55	2017-09-22 15:14:55	23:59:59	00:00:00	\N	04144997927	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 110	137	f	-1	\N	2017-09-22 15:14:55	default	ANGELASOTO	0	0
2017-09-22 15:17:54	2017-09-22 15:17:54	2017-09-22 15:17:54	23:59:59	00:00:00	\N	04245295848	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 111	138	f	-1	\N	2017-09-22 15:17:54	default	EVANS	0	0
2017-09-22 15:23:30	2017-09-22 15:23:30	2017-09-22 15:23:30	23:59:59	00:00:00	\N	04161757163	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 112	139	f	-1	\N	2017-09-22 15:23:30	default	ANGELASOTO	0	0
2017-09-22 15:26:00	2017-09-22 15:26:00	2017-09-22 15:26:00	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 113	140	f	-1	\N	2017-09-22 15:26:00	default	EVANS	0	0
2017-09-22 15:32:11	2017-09-22 15:32:11	2017-09-22 15:32:11	23:59:59	00:00:00	\N	04267245311	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 114	141	f	-1	\N	2017-09-22 15:32:11	default	ANGELASOTO	0	0
2017-09-22 15:34:00	2017-09-22 15:34:00	2017-09-22 15:34:00	23:59:59	00:00:00	\N	04245295848	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 115	142	f	-1	\N	2017-09-22 15:34:00	default	EVANS	0	0
2017-09-22 15:36:07	2017-09-22 15:36:07	2017-09-22 15:36:07	23:59:59	00:00:00	\N	04245308863	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 116	143	f	-1	\N	2017-09-22 15:36:07	default	GENESISLEON	0	0
2017-09-22 15:40:04	2017-09-22 15:40:04	2017-09-22 15:40:04	23:59:59	00:00:00	\N	04126766449	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 117	144	f	-1	\N	2017-09-22 15:40:04	default	EVANS	0	0
2017-09-22 15:41:27	2017-09-22 15:41:27	2017-09-22 15:41:27	23:59:59	00:00:00	\N	04125045470	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 118	145	f	-1	\N	2017-09-22 15:41:27	default	FRANCIS	0	0
2017-09-22 15:43:01	2017-09-22 15:43:01	2017-09-22 15:43:01	23:59:59	00:00:00	\N	04245308863	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 119	146	f	-1	\N	2017-09-22 15:43:01	default	GENESISLEON	0	0
2017-09-22 15:43:42	2017-09-22 15:43:42	2017-09-22 15:43:42	23:59:59	00:00:00	\N	04125221283	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 120	147	f	-1	\N	2017-09-22 15:43:42	default	MARYCORDERO	0	0
2017-09-22 15:44:39	2017-09-22 15:44:39	2017-09-22 15:44:39	23:59:59	00:00:00	\N	04261494866	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 121	148	f	-1	\N	2017-09-22 15:44:39	default	ANGELASOTO	0	0
2017-09-22 15:49:52	2017-09-22 15:49:52	2017-09-22 15:49:52	23:59:59	00:00:00	\N	04149558640	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 123	149	f	-1	\N	2017-09-22 15:49:52	default	EVANS	0	0
2017-09-22 15:53:37	2017-09-22 15:53:37	2017-09-22 15:53:37	23:59:59	00:00:00	\N	04164483874	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 124	150	f	-1	\N	2017-09-22 15:53:37	default	EVANS	0	0
2017-09-22 15:55:25	2017-09-22 15:55:25	2017-09-22 15:55:25	23:59:59	00:00:00	\N	04144103933	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 125	151	f	-1	\N	2017-09-22 15:55:25	default	FRANCIS	0	0
2017-09-22 15:58:47	2017-09-22 15:58:47	2017-09-22 15:58:47	23:59:59	00:00:00	\N	04146710230	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 126	152	f	-1	\N	2017-09-22 15:58:47	default	EVANS	0	0
2017-09-22 16:01:22	2017-09-22 16:01:22	2017-09-22 16:01:22	23:59:59	00:00:00	\N	04245269957	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 127	153	f	-1	\N	2017-09-22 16:01:22	default	ANGELASOTO	0	0
2017-09-22 16:01:24	2017-09-22 16:01:24	2017-09-22 16:01:24	23:59:59	00:00:00	\N	04161541384	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 128	154	f	-1	\N	2017-09-22 16:01:24	default	EVANS	0	0
2017-09-22 16:01:44	2017-09-22 16:01:44	2017-09-22 16:01:44	23:59:59	00:00:00	\N	04168582230	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 129	155	f	-1	\N	2017-09-22 16:01:44	default	MARYCORDERO	0	0
2017-09-22 16:05:37	2017-09-22 16:05:37	2017-09-22 16:05:37	23:59:59	00:00:00	\N	04160641259	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 130	156	f	-1	\N	2017-09-22 16:05:37	default	GENESISLEON	0	0
2017-09-22 16:06:30	2017-09-22 16:06:30	2017-09-22 16:06:30	23:59:59	00:00:00	\N	04168582230	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 131	157	f	-1	\N	2017-09-22 16:06:30	default	MARYCORDERO	0	0
2017-09-22 16:08:22	2017-09-22 16:08:22	2017-09-22 16:08:22	23:59:59	00:00:00	\N	04161531877	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 132	158	f	-1	\N	2017-09-22 16:08:22	default	EVANS	0	0
2017-09-22 16:12:26	2017-09-22 16:12:26	2017-09-22 16:12:26	23:59:59	00:00:00	\N	04263353134	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 133	159	f	-1	\N	2017-09-22 16:12:26	default	ANGELASOTO	0	0
2017-09-22 16:13:19	2017-09-22 16:13:19	2017-09-22 16:13:19	23:59:59	00:00:00	\N	04144103933	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 134	160	f	-1	\N	2017-09-22 16:13:19	default	FRANCIS	0	0
2017-09-22 16:18:39	2017-09-22 16:18:39	2017-09-22 16:18:39	23:59:59	00:00:00	\N	04167448321	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 135	161	f	-1	\N	2017-09-22 16:18:39	default	EVANS	0	0
2017-09-22 16:20:22	2017-09-22 16:20:22	2017-09-22 16:20:22	23:59:59	00:00:00	\N	04167547386	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 136	162	f	-1	\N	2017-09-22 16:20:22	default	MARYCORDERO	0	0
2017-09-22 16:21:55	2017-09-22 16:21:55	2017-09-22 16:21:55	23:59:59	00:00:00	\N	04245548663	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 137	163	f	-1	\N	2017-09-22 16:21:55	default	GENESISLEON	0	0
2017-09-22 16:22:27	2017-09-22 16:22:27	2017-09-22 16:22:27	23:59:59	00:00:00	\N	04167448321	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 138	164	f	-1	\N	2017-09-22 16:22:27	default	EVANS	0	0
2017-09-22 16:36:48	2017-09-22 16:36:48	2017-09-22 16:36:48	23:59:59	00:00:00	\N	04160641259	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 140	165	f	-1	\N	2017-09-22 16:36:48	default	GENESISLEON	0	0
2017-09-22 16:39:52	2017-09-22 16:39:52	2017-09-22 16:39:52	23:59:59	00:00:00	\N	04269574064	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 141	166	f	-1	\N	2017-09-22 16:39:52	default	MARYCORDERO	0	0
2017-09-22 16:52:27	2017-09-22 16:52:27	2017-09-22 16:52:27	23:59:59	00:00:00	\N	04245482620	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 143	167	f	-1	\N	2017-09-22 16:52:27	default	FRANCIS	0	0
2017-09-22 16:55:27	2017-09-22 16:55:27	2017-09-22 16:55:27	23:59:59	00:00:00	\N	04167370044	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 144	168	f	-1	\N	2017-09-22 16:55:27	default	ANGELASOTO	0	0
2017-09-22 17:01:17	2017-09-22 17:01:17	2017-09-22 17:01:17	23:59:59	00:00:00	\N	04145332446	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 145	169	f	-1	\N	2017-09-22 17:01:17	default	GENESISLEON	0	0
2017-09-22 17:05:07	2017-09-22 17:05:07	2017-09-22 17:05:07	23:59:59	00:00:00	\N	04267595141	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 146	170	f	-1	\N	2017-09-22 17:05:07	default	FRANCIS	0	0
2017-09-22 17:05:50	2017-09-22 17:05:50	2017-09-22 17:05:50	23:59:59	00:00:00	\N	04261146103	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 147	171	f	-1	\N	2017-09-22 17:05:50	default	ANGELASOTO	0	0
2017-09-22 17:11:37	2017-09-22 17:11:37	2017-09-22 17:11:37	23:59:59	00:00:00	\N	04262302952	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 148	172	f	-1	\N	2017-09-22 17:11:37	default	GENESISLEON	0	0
2017-09-22 17:14:04	2017-09-22 17:14:04	2017-09-22 17:14:04	23:59:59	00:00:00	\N	04121515576	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 149	173	f	-1	\N	2017-09-22 17:14:04	default	MARYCORDERO	0	0
2017-09-22 17:15:45	2017-09-22 17:15:45	2017-09-22 17:15:45	23:59:59	00:00:00	\N	04120511175	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 150	174	f	-1	\N	2017-09-22 17:15:45	default	ANGELASOTO	0	0
2017-09-22 17:20:05	2017-09-22 17:20:05	2017-09-22 17:20:05	23:59:59	00:00:00	\N	04120511175	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 151	175	f	-1	\N	2017-09-22 17:20:05	default	ANGELASOTO	0	0
2017-09-22 17:39:12	2017-09-22 17:39:12	2017-09-22 17:39:12	23:59:59	00:00:00	\N	04149525997	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 152	176	f	-1	\N	2017-09-22 17:39:12	default	MARYCORDERO	0	0
2017-09-25 08:34:46	2017-09-25 08:34:46	2017-09-25 08:34:46	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 153	177	f	-1	\N	2017-09-25 08:34:46	default	ANGELASOTO	0	0
2017-09-25 08:37:30	2017-09-25 08:37:30	2017-09-25 08:37:30	23:59:59	00:00:00	\N	04266576846	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12041	178	f	-1	\N	2017-09-25 08:37:30	default	jrangel	0	0
2017-09-25 08:39:05	2017-09-25 08:39:05	2017-09-25 08:39:05	23:59:59	00:00:00	\N	04245666883	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 154	179	f	-1	\N	2017-09-25 08:39:05	default	GENESISLEON	0	0
2017-09-25 08:41:29	2017-09-25 08:41:29	2017-09-25 08:41:29	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 155	180	f	-1	\N	2017-09-25 08:41:29	default	ANGELASOTO	0	0
2017-09-25 09:10:46	2017-09-25 09:10:46	2017-09-25 09:10:46	23:59:59	00:00:00	\N	04245486468	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12042	181	f	-1	\N	2017-09-25 09:10:46	default	Olarmelina	0	0
2017-09-25 09:28:49	2017-09-25 09:28:49	2017-09-25 09:28:49	23:59:59	00:00:00	\N	04167519207	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12043	182	f	-1	\N	2017-09-25 09:28:49	default	douglasr	0	0
2017-09-25 09:33:40	2017-09-25 09:33:40	2017-09-25 09:33:40	23:59:59	00:00:00	\N	04245957874	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12044	183	f	-1	\N	2017-09-25 09:33:40	default	Olarmelina	0	0
2017-09-25 09:59:53	2017-09-25 09:59:53	2017-09-25 09:59:53	23:59:59	00:00:00	\N	04162578266	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12045	184	f	-1	\N	2017-09-25 09:59:53	default	Olarmelina	0	0
2017-09-25 10:14:58	2017-09-25 10:14:58	2017-09-25 10:14:58	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 156	185	f	-1	\N	2017-09-25 10:14:58	default	ANGELASOTO	0	0
2017-09-25 10:18:04	2017-09-25 10:18:04	2017-09-25 10:18:04	23:59:59	00:00:00	\N	04245666883	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 157	186	f	-1	\N	2017-09-25 10:18:04	default	GENESISLEON	0	0
2017-09-25 10:24:01	2017-09-25 10:24:01	2017-09-25 10:24:01	23:59:59	00:00:00	\N	04245283856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 158	187	f	-1	\N	2017-09-25 10:24:01	default	ANGELASOTO	0	0
2017-09-25 10:24:10	2017-09-25 10:24:10	2017-09-25 10:24:10	23:59:59	00:00:00	\N	04161257654	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12046	188	f	-1	\N	2017-09-25 10:24:10	default	Olarmelina	0	0
2017-09-25 10:25:20	2017-09-25 10:25:20	2017-09-25 10:25:20	23:59:59	00:00:00	\N	04161980834	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 159	189	f	-1	\N	2017-09-25 10:25:20	default	MARIA	0	0
2017-09-25 10:30:26	2017-09-25 10:30:26	2017-09-25 10:30:26	23:59:59	00:00:00	\N	04141001421	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 160	190	f	-1	\N	2017-09-25 10:30:26	default	ANGELASOTO	0	0
2017-09-25 10:32:35	2017-09-25 10:32:35	2017-09-25 10:32:35	23:59:59	00:00:00	\N	04261506759	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 161	191	f	-1	\N	2017-09-25 10:32:35	default	FRANCIS	0	0
2017-09-25 10:33:46	2017-09-25 10:33:46	2017-09-25 10:33:46	23:59:59	00:00:00	\N	04245286513	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 162	192	f	-1	\N	2017-09-25 10:33:46	default	GENESISLEON	0	0
2017-09-25 10:34:39	2017-09-25 10:34:39	2017-09-25 10:34:39	23:59:59	00:00:00	\N	04141001421	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 163	193	f	-1	\N	2017-09-25 10:34:39	default	ANGELASOTO	0	0
2017-09-25 10:36:23	2017-09-25 10:36:23	2017-09-25 10:36:23	23:59:59	00:00:00	\N	04168290768	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12047	194	f	-1	\N	2017-09-25 10:36:23	default	griselda	0	0
2017-09-25 10:37:44	2017-09-25 10:37:44	2017-09-25 10:37:44	23:59:59	00:00:00	\N	04264596359	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12048	195	f	-1	\N	2017-09-25 10:37:44	default	Olarmelina	0	0
2017-09-25 10:39:17	2017-09-25 10:39:17	2017-09-25 10:39:17	23:59:59	00:00:00	\N	04261506759	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 164	196	f	-1	\N	2017-09-25 10:39:17	default	FRANCIS	0	0
2017-09-25 10:42:54	2017-09-25 10:42:54	2017-09-25 10:42:54	23:59:59	00:00:00	\N	04161257654	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12049	197	f	-1	\N	2017-09-25 10:42:54	default	douglasr	0	0
2017-09-25 10:44:35	2017-09-25 10:44:35	2017-09-25 10:44:35	23:59:59	00:00:00	\N	04266546685	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 165	198	f	-1	\N	2017-09-25 10:44:35	default	GENESISLEON	0	0
2017-09-25 10:47:38	2017-09-25 10:47:38	2017-09-25 10:47:38	23:59:59	00:00:00	\N	04263521626	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12050	199	f	-1	\N	2017-09-25 10:47:38	default	jrangel	0	0
2017-09-25 10:52:13	2017-09-25 10:52:13	2017-09-25 10:52:13	23:59:59	00:00:00	\N	04120530796	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12051	200	f	-1	\N	2017-09-25 10:52:13	default	douglasr	0	0
2017-09-25 10:56:38	2017-09-25 10:56:38	2017-09-25 10:56:38	23:59:59	00:00:00	\N	04145095931	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 166	201	f	-1	\N	2017-09-25 10:56:38	default	ANGELASOTO	0	0
2017-09-25 11:02:31	2017-09-25 11:02:31	2017-09-25 11:02:31	23:59:59	00:00:00	\N	04143574207	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 167	202	f	-1	\N	2017-09-25 11:02:31	default	MARIA	0	0
2017-09-25 11:02:35	2017-09-25 11:02:35	2017-09-25 11:02:35	23:59:59	00:00:00	\N	04168572171	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 168	203	f	-1	\N	2017-09-25 11:02:35	default	FRANCIS	0	0
2017-09-25 11:04:00	2017-09-25 11:04:00	2017-09-25 11:04:00	23:59:59	00:00:00	\N	04145244439	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 169	204	f	-1	\N	2017-09-25 11:04:00	default	GENESISLEON	0	0
2017-09-25 11:06:13	2017-09-25 11:06:13	2017-09-25 11:06:13	23:59:59	00:00:00	\N	04168572171	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 170	205	f	-1	\N	2017-09-25 11:06:13	default	FRANCIS	0	0
2017-09-25 11:10:54	2017-09-25 11:10:54	2017-09-25 11:10:54	23:59:59	00:00:00	\N	04245552765	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 171	206	f	-1	\N	2017-09-25 11:10:54	default	ANGELASOTO	0	0
2017-09-25 11:14:11	2017-09-25 11:14:11	2017-09-25 11:14:11	23:59:59	00:00:00	\N	04267352479	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 172	207	f	-1	\N	2017-09-25 11:14:11	default	GENESISLEON	0	0
2017-09-25 11:14:42	2017-09-25 11:14:42	2017-09-25 11:14:42	23:59:59	00:00:00	\N	04169906127	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 173	208	f	-1	\N	2017-09-25 11:14:42	default	genesis	0	0
2017-09-25 11:19:43	2017-09-25 11:19:43	2017-09-25 11:19:43	23:59:59	00:00:00	\N	04262588491	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12053	209	f	-1	\N	2017-09-25 11:19:43	default	griselda	0	0
2017-09-25 11:20:16	2017-09-25 11:20:16	2017-09-25 11:20:16	23:59:59	00:00:00	\N	04261096342	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 174	210	f	-1	\N	2017-09-25 11:20:16	default	FRANCIS	0	0
2017-09-25 11:20:25	2017-09-25 11:20:25	2017-09-25 11:20:25	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 175	211	f	-1	\N	2017-09-25 11:20:25	default	ANGELASOTO	0	0
2017-09-25 11:22:14	2017-09-25 11:22:14	2017-09-25 11:22:14	23:59:59	00:00:00	\N	04264597701	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12054	212	f	-1	\N	2017-09-25 11:22:14	default	jrangel	0	0
2017-09-25 11:28:35	2017-09-25 11:28:35	2017-09-25 11:28:35	23:59:59	00:00:00	\N	04269774083	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 176	213	f	-1	\N	2017-09-25 11:28:35	default	FRANCIS	0	0
2017-09-25 11:31:27	2017-09-25 11:31:27	2017-09-25 11:31:27	23:59:59	00:00:00	\N	04263635057	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 178	214	f	-1	\N	2017-09-25 11:31:27	default	GENESISLEON	0	0
2017-09-25 11:38:42	2017-09-25 11:38:42	2017-09-25 11:38:42	23:59:59	00:00:00	\N	04264896390	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 179	215	f	-1	\N	2017-09-25 11:38:42	default	ANGELASOTO	0	0
2017-09-25 11:43:01	2017-09-25 11:43:01	2017-09-25 11:43:01	23:59:59	00:00:00	\N	04163345135	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 180	216	f	-1	\N	2017-09-25 11:43:01	default	GENESISLEON	0	0
2017-09-25 11:43:27	2017-09-25 11:43:27	2017-09-25 11:43:27	23:59:59	00:00:00	\N	04269450814	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 181	217	f	-1	\N	2017-09-25 11:43:27	default	MARIA	0	0
2017-09-25 11:44:57	2017-09-25 11:44:57	2017-09-25 11:44:57	23:59:59	00:00:00	\N	04160552528	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 182	218	f	-1	\N	2017-09-25 11:44:57	default	MARYCORDERO	0	0
2017-09-25 11:47:34	2017-09-25 11:47:34	2017-09-25 11:47:34	23:59:59	00:00:00	\N	04245589657	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 183	219	f	-1	\N	2017-09-25 11:47:34	default	EVANS	0	0
2017-09-25 11:53:34	2017-09-25 11:53:34	2017-09-25 11:53:34	23:59:59	00:00:00	\N	04145365118	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 184	220	f	-1	\N	2017-09-25 11:53:34	default	GENESISLEON	0	0
2017-09-25 11:55:01	2017-09-25 11:55:01	2017-09-25 11:55:01	23:59:59	00:00:00	\N	04241239584	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 185	221	f	-1	\N	2017-09-25 11:55:01	default	FRANCIS	0	0
2017-09-25 11:59:00	2017-09-25 11:59:00	2017-09-25 11:59:00	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 186	222	f	-1	\N	2017-09-25 11:59:00	default	ANGELASOTO	0	0
2017-09-25 12:01:14	2017-09-25 12:01:14	2017-09-25 12:01:14	23:59:59	00:00:00	\N	04245589657	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 187	223	f	-1	\N	2017-09-25 12:01:14	default	EVANS	0	0
2017-09-25 12:05:17	2017-09-25 12:05:17	2017-09-25 12:05:17	23:59:59	00:00:00	\N	04241239584	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 189	224	f	-1	\N	2017-09-25 12:05:17	default	FRANCIS	0	0
2017-09-25 12:06:06	2017-09-25 12:06:06	2017-09-25 12:06:06	23:59:59	00:00:00	\N	04145244439	Default_No_Compression	\N	-1	@rafaelcalles: Su Solicitud Fue ANULADA, Para Mas Información Consulte su ticket por Internet o Visite Nuestras Oficinas.; Ticket Nro.: 169	225	f	-1	\N	2017-09-25 12:06:06	default	GENESISLEON	0	0
2017-09-25 12:06:44	2017-09-25 12:06:44	2017-09-25 12:06:44	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 190	226	f	-1	\N	2017-09-25 12:06:44	default	ANGELASOTO	0	0
2017-09-25 12:06:46	2017-09-25 12:06:46	2017-09-25 12:06:46	23:59:59	00:00:00	\N	04145244439	Default_No_Compression	\N	-1	@rafaelcalles: Su Solicitud Fue ANULADA, Para Mas Información Consulte su ticket por Internet o Visite Nuestras Oficinas.; Ticket Nro.: 169	227	f	-1	\N	2017-09-25 12:06:46	default	GENESISLEON	0	0
2017-09-25 12:07:46	2017-09-25 12:07:46	2017-09-25 12:07:46	23:59:59	00:00:00	\N	04245242374	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 191	228	f	-1	\N	2017-09-25 12:07:46	default	MARYCORDERO	0	0
2017-09-25 12:16:58	2017-09-25 12:16:58	2017-09-25 12:16:58	23:59:59	00:00:00	\N	04268351354	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 192	229	f	-1	\N	2017-09-25 12:16:58	default	GENESISLEON	0	0
2017-09-25 12:18:26	2017-09-25 12:18:26	2017-09-25 12:18:26	23:59:59	00:00:00	\N	04126764700	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 193	230	f	-1	\N	2017-09-25 12:18:26	default	FRANCIS	0	0
2017-09-25 12:25:47	2017-09-25 12:25:47	2017-09-25 12:25:47	23:59:59	00:00:00	\N	04161575531	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 194	231	f	-1	\N	2017-09-25 12:25:47	default	GENESISLEON	0	0
2017-09-25 12:31:27	2017-09-25 12:31:27	2017-09-25 12:31:27	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 195	232	f	-1	\N	2017-09-25 12:31:27	default	ANGELASOTO	0	0
2017-09-25 12:32:12	2017-09-25 12:32:12	2017-09-25 12:32:12	23:59:59	00:00:00	\N	04145668253	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 196	233	f	-1	\N	2017-09-25 12:32:12	default	GENESISLEON	0	0
2017-09-25 12:36:58	2017-09-25 12:36:58	2017-09-25 12:36:58	23:59:59	00:00:00	\N	04164424033	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 197	234	f	-1	\N	2017-09-25 12:36:58	default	MARIA	0	0
2017-09-25 12:37:00	2017-09-25 12:37:00	2017-09-25 12:37:00	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 198	235	f	-1	\N	2017-09-25 12:37:00	default	ANGELASOTO	0	0
2017-09-25 12:39:57	2017-09-25 12:39:57	2017-09-25 12:39:57	23:59:59	00:00:00	\N	04263091839	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 199	236	f	-1	\N	2017-09-25 12:39:57	default	GENESISLEON	0	0
2017-09-25 12:41:34	2017-09-25 12:41:34	2017-09-25 12:41:34	23:59:59	00:00:00	\N	04263520174	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 200	237	f	-1	\N	2017-09-25 12:41:34	default	ERIKAMANTILLA	0	0
2017-09-25 12:45:06	2017-09-25 12:45:06	2017-09-25 12:45:06	23:59:59	00:00:00	\N	04261589827	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 201	238	f	-1	\N	2017-09-25 12:45:06	default	MARIA	0	0
2017-09-25 12:45:23	2017-09-25 12:45:23	2017-09-25 12:45:23	23:59:59	00:00:00	\N	04167570602	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 202	239	f	-1	\N	2017-09-25 12:45:23	default	FRANCIS	0	0
2017-09-25 12:46:16	2017-09-25 12:46:16	2017-09-25 12:46:16	23:59:59	00:00:00	\N	04269552981	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 203	240	f	-1	\N	2017-09-25 12:46:16	default	ANGELASOTO	0	0
2017-09-25 13:05:47	2017-09-25 13:05:47	2017-09-25 13:05:47	23:59:59	00:00:00	\N	04245109446	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 204	241	f	-1	\N	2017-09-25 13:05:47	default	EVANS	0	0
2017-09-25 13:10:23	2017-09-25 13:10:23	2017-09-25 13:10:23	23:59:59	00:00:00	\N	04145347915	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 205	242	f	-1	\N	2017-09-25 13:10:23	default	ANGELASOTO	0	0
2017-09-25 13:11:51	2017-09-25 13:11:51	2017-09-25 13:11:51	23:59:59	00:00:00	\N	04165757345	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 206	243	f	-1	\N	2017-09-25 13:11:51	default	GENESISLEON	0	0
2017-09-25 13:16:13	2017-09-25 13:16:13	2017-09-25 13:16:13	23:59:59	00:00:00	\N	04123903053	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 207	244	f	-1	\N	2017-09-25 13:16:13	default	MARIA	0	0
2017-09-25 13:24:22	2017-09-25 13:24:22	2017-09-25 13:24:22	23:59:59	00:00:00	\N	04245221960	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 208	245	f	-1	\N	2017-09-25 13:24:22	default	ANGELASOTO	0	0
2017-09-25 13:27:21	2017-09-25 13:27:21	2017-09-25 13:27:21	23:59:59	00:00:00	\N	04261444520	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 209	246	f	-1	\N	2017-09-25 13:27:21	default	EVANS	0	0
2017-09-25 13:27:33	2017-09-25 13:27:33	2017-09-25 13:27:33	23:59:59	00:00:00	\N	04245421500	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 210	247	f	-1	\N	2017-09-25 13:27:33	default	MARIA	0	0
2017-09-25 13:30:12	2017-09-25 13:30:12	2017-09-25 13:30:12	23:59:59	00:00:00	\N	04145064476	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 211	248	f	-1	\N	2017-09-25 13:30:12	default	ANGELASOTO	0	0
2017-09-25 13:34:42	2017-09-25 13:34:42	2017-09-25 13:34:42	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 212	249	f	-1	\N	2017-09-25 13:34:42	default	ANGELASOTO	0	0
2017-09-25 13:36:20	2017-09-25 13:36:20	2017-09-25 13:36:20	23:59:59	00:00:00	\N	04140542244	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 213	250	f	-1	\N	2017-09-25 13:36:20	default	GENESISLEON	0	0
2017-09-25 13:41:36	2017-09-25 13:41:36	2017-09-25 13:41:36	23:59:59	00:00:00	\N	04245693810	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 214	251	f	-1	\N	2017-09-25 13:41:36	default	ANGELASOTO	0	0
2017-09-25 13:48:08	2017-09-25 13:48:08	2017-09-25 13:48:08	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 215	252	f	-1	\N	2017-09-25 13:48:08	default	ANGELASOTO	0	0
2017-09-25 13:48:48	2017-09-25 13:48:48	2017-09-25 13:48:48	23:59:59	00:00:00	\N	04269506211	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 216	253	f	-1	\N	2017-09-25 13:48:48	default	EVANS	0	0
2017-09-25 13:49:39	2017-09-25 13:49:39	2017-09-25 13:49:39	23:59:59	00:00:00	\N	04140542244	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 217	254	f	-1	\N	2017-09-25 13:49:39	default	ERIKAMANTILLA	0	0
2017-09-25 13:52:22	2017-09-25 13:52:22	2017-09-25 13:52:22	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 218	255	f	-1	\N	2017-09-25 13:52:22	default	ANGELASOTO	0	0
2017-09-25 14:01:14	2017-09-25 14:01:14	2017-09-25 14:01:14	23:59:59	00:00:00	\N	04263520174	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 219	256	f	-1	\N	2017-09-25 14:01:14	default	lina	0	0
2017-09-25 14:02:21	2017-09-25 14:02:21	2017-09-25 14:02:21	23:59:59	00:00:00	\N	04160416039	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 220	257	f	-1	\N	2017-09-25 14:02:21	default	EVANS	0	0
2017-09-25 14:11:37	2017-09-25 14:11:37	2017-09-25 14:11:37	23:59:59	00:00:00	\N	04160374756	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 221	258	f	-1	\N	2017-09-25 14:11:37	default	MARIA	0	0
2017-09-25 14:13:42	2017-09-25 14:13:42	2017-09-25 14:13:42	23:59:59	00:00:00	\N	04267167226	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 222	259	f	-1	\N	2017-09-25 14:13:42	default	FRANCIS	0	0
2017-09-25 14:21:34	2017-09-25 14:21:34	2017-09-25 14:21:34	23:59:59	00:00:00	\N	04165564287	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12055	260	f	-1	\N	2017-09-25 14:21:34	default	douglasr	0	0
2017-09-25 14:22:16	2017-09-25 14:22:16	2017-09-25 14:22:16	23:59:59	00:00:00	\N	04160370879	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 225	261	f	-1	\N	2017-09-25 14:22:16	default	EVANS	0	0
2017-09-25 14:23:00	2017-09-25 14:23:00	2017-09-25 14:23:00	23:59:59	00:00:00	\N	04160589219	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 226	262	f	-1	\N	2017-09-25 14:23:00	default	lina	0	0
2017-09-25 14:24:12	2017-09-25 14:24:12	2017-09-25 14:24:12	23:59:59	00:00:00	\N	04245301771	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12056	263	f	-1	\N	2017-09-25 14:24:12	default	Olarmelina	0	0
2017-09-25 14:26:36	2017-09-25 14:26:36	2017-09-25 14:26:36	23:59:59	00:00:00	\N	04160589219	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 228	264	f	-1	\N	2017-09-25 14:26:36	default	lina	0	0
2017-09-25 14:30:12	2017-09-25 14:30:12	2017-09-25 14:30:12	23:59:59	00:00:00	\N	04160589219	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 230	265	f	-1	\N	2017-09-25 14:30:12	default	lina	0	0
2017-09-25 14:33:48	2017-09-25 14:33:48	2017-09-25 14:33:48	23:59:59	00:00:00	\N	04245482620	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 232	266	f	-1	\N	2017-09-25 14:33:48	default	FRANCIS	0	0
2017-09-25 14:35:54	2017-09-25 14:35:54	2017-09-25 14:35:54	23:59:59	00:00:00	\N	04160542363	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 233	267	f	-1	\N	2017-09-25 14:35:54	default	lina	0	0
2017-09-25 14:39:16	2017-09-25 14:39:16	2017-09-25 14:39:16	23:59:59	00:00:00	\N	04145743733	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 234	268	f	-1	\N	2017-09-25 14:39:16	default	ANGELASOTO	0	0
2017-09-25 14:43:59	2017-09-25 14:43:59	2017-09-25 14:43:59	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 235	269	f	-1	\N	2017-09-25 14:43:59	default	ANGELASOTO	0	0
2017-09-25 14:49:11	2017-09-25 14:49:11	2017-09-25 14:49:11	23:59:59	00:00:00	\N	04264208545	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 236	270	f	-1	\N	2017-09-25 14:49:11	default	ANGELASOTO	0	0
2017-09-25 14:51:42	2017-09-25 14:51:42	2017-09-25 14:51:42	23:59:59	00:00:00	\N	04261179069	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 237	271	f	-1	\N	2017-09-25 14:51:42	default	FRANCIS	0	0
2017-09-25 14:52:13	2017-09-25 14:52:13	2017-09-25 14:52:13	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 238	272	f	-1	\N	2017-09-25 14:52:13	default	ANGELASOTO	0	0
2017-09-25 14:53:13	2017-09-25 14:53:13	2017-09-25 14:53:13	23:59:59	00:00:00	\N	04245295848	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 239	273	f	-1	\N	2017-09-25 14:53:13	default	lina	0	0
2017-09-25 14:53:32	2017-09-25 14:53:32	2017-09-25 14:53:32	23:59:59	00:00:00	\N	04261179069	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 240	274	f	-1	\N	2017-09-25 14:53:32	default	FRANCIS	0	0
2017-09-25 14:56:26	2017-09-25 14:56:26	2017-09-25 14:56:26	23:59:59	00:00:00	\N	04267079847	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 241	275	f	-1	\N	2017-09-25 14:56:26	default	ANGELASOTO	0	0
2017-09-25 15:03:10	2017-09-25 15:03:10	2017-09-25 15:03:10	23:59:59	00:00:00	\N	04145224830	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 242	276	f	-1	\N	2017-09-25 15:03:10	default	ANGELASOTO	0	0
2017-09-25 15:07:35	2017-09-25 15:07:35	2017-09-25 15:07:35	23:59:59	00:00:00	\N	04145087607	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 243	277	f	-1	\N	2017-09-25 15:07:35	default	ANGELASOTO	0	0
2017-09-25 15:09:10	2017-09-25 15:09:10	2017-09-25 15:09:10	23:59:59	00:00:00	\N	04120135613	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 244	278	f	-1	\N	2017-09-25 15:09:10	default	ERIKAMANTILLA	0	0
2017-09-25 15:11:27	2017-09-25 15:11:27	2017-09-25 15:11:27	23:59:59	00:00:00	\N	04145743733	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 245	279	f	-1	\N	2017-09-25 15:11:27	default	ANGELASOTO	0	0
2017-09-25 15:12:34	2017-09-25 15:12:34	2017-09-25 15:12:34	23:59:59	00:00:00	\N	04125255718	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12057	280	f	-1	\N	2017-09-25 15:12:34	default	douglasr	0	0
2017-09-25 15:14:20	2017-09-25 15:14:20	2017-09-25 15:14:20	23:59:59	00:00:00	\N	04168571832	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12058	281	f	-1	\N	2017-09-25 15:14:20	default	Olarmelina	0	0
2017-09-25 15:15:02	2017-09-25 15:15:02	2017-09-25 15:15:02	23:59:59	00:00:00	\N	04245011352	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 246	282	f	-1	\N	2017-09-25 15:15:02	default	ANGELASOTO	0	0
2017-09-25 15:18:04	2017-09-25 15:18:04	2017-09-25 15:18:04	23:59:59	00:00:00	\N	04266584310	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 247	283	f	-1	\N	2017-09-25 15:18:04	default	EVANS	0	0
2017-09-25 15:18:27	2017-09-25 15:18:27	2017-09-25 15:18:27	23:59:59	00:00:00	\N	04125222719	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 248	284	f	-1	\N	2017-09-25 15:18:27	default	lina	0	0
2017-09-25 15:21:49	2017-09-25 15:21:49	2017-09-25 15:21:49	23:59:59	00:00:00	\N	04264208545	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 249	285	f	-1	\N	2017-09-25 15:21:49	default	ANGELASOTO	0	0
2017-09-25 15:21:51	2017-09-25 15:21:51	2017-09-25 15:21:51	23:59:59	00:00:00	\N	04264208545	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 250	286	f	-1	\N	2017-09-25 15:21:51	default	ANGELASOTO	0	0
2017-09-25 15:24:23	2017-09-25 15:24:23	2017-09-25 15:24:23	23:59:59	00:00:00	\N	04120135613	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 251	287	f	-1	\N	2017-09-25 15:24:23	default	ERIKAMANTILLA	0	0
2017-09-25 15:29:40	2017-09-25 15:29:40	2017-09-25 15:29:40	23:59:59	00:00:00	\N	04145641863	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 252	288	f	-1	\N	2017-09-25 15:29:40	default	ANGELASOTO	0	0
2017-09-25 15:32:53	2017-09-25 15:32:53	2017-09-25 15:32:53	23:59:59	00:00:00	\N	04149292740	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 253	289	f	-1	\N	2017-09-25 15:32:53	default	EVANS	0	0
2017-09-25 15:33:51	2017-09-25 15:33:51	2017-09-25 15:33:51	23:59:59	00:00:00	\N	04167531647	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12059	290	f	-1	\N	2017-09-25 15:33:51	default	Olarmelina	0	0
2017-09-25 15:41:16	2017-09-25 15:41:16	2017-09-25 15:41:16	23:59:59	00:00:00	\N	04269353764	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 254	291	f	-1	\N	2017-09-25 15:41:16	default	EVANS	0	0
2017-09-25 15:42:45	2017-09-25 15:42:45	2017-09-25 15:42:45	23:59:59	00:00:00	\N	04120576911	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12060	292	f	-1	\N	2017-09-25 15:42:45	default	Olarmelina	0	0
2017-09-25 15:47:19	2017-09-25 15:47:19	2017-09-25 15:47:19	23:59:59	00:00:00	\N	04269353764	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 255	293	f	-1	\N	2017-09-25 15:47:19	default	EVANS	0	0
2017-09-25 15:52:22	2017-09-25 15:52:22	2017-09-25 15:52:22	23:59:59	00:00:00	\N	04163772132	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 256	294	f	-1	\N	2017-09-25 15:52:22	default	ERIKAMANTILLA	0	0
2017-09-25 15:52:45	2017-09-25 15:52:45	2017-09-25 15:52:45	23:59:59	00:00:00	\N	04245257650	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 257	295	f	-1	\N	2017-09-25 15:52:45	default	EVANS	0	0
2017-09-25 16:01:01	2017-09-25 16:01:01	2017-09-25 16:01:01	23:59:59	00:00:00	\N	04145149294	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 258	296	f	-1	\N	2017-09-25 16:01:01	default	EVANS	0	0
2017-09-25 16:05:41	2017-09-25 16:05:41	2017-09-25 16:05:41	23:59:59	00:00:00	\N	04163772132	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 259	297	f	-1	\N	2017-09-25 16:05:41	default	ERIKAMANTILLA	0	0
2017-09-25 16:06:24	2017-09-25 16:06:24	2017-09-25 16:06:24	23:59:59	00:00:00	\N	04161267276	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 260	298	f	-1	\N	2017-09-25 16:06:24	default	EVANS	0	0
2017-09-25 16:06:55	2017-09-25 16:06:55	2017-09-25 16:06:55	23:59:59	00:00:00	\N	04263059326	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 261	299	f	-1	\N	2017-09-25 16:06:55	default	ANGELASOTO	0	0
2017-09-25 16:15:25	2017-09-25 16:15:25	2017-09-25 16:15:25	23:59:59	00:00:00	\N	04262740255	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 262	300	f	-1	\N	2017-09-25 16:15:25	default	ANGELASOTO	0	0
2017-09-25 16:21:08	2017-09-25 16:21:08	2017-09-25 16:21:08	23:59:59	00:00:00	\N	04127764856	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 263	301	f	-1	\N	2017-09-25 16:21:08	default	ERIKAMANTILLA	0	0
2017-09-25 16:23:13	2017-09-25 16:23:13	2017-09-25 16:23:13	23:59:59	00:00:00	\N	04145664826	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 264	302	f	-1	\N	2017-09-25 16:23:13	default	lina	0	0
2017-09-25 16:25:00	2017-09-25 16:25:00	2017-09-25 16:25:00	23:59:59	00:00:00	\N	04269531987	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 265	303	f	-1	\N	2017-09-25 16:25:00	default	ANGELASOTO	0	0
2017-09-25 16:30:10	2017-09-25 16:30:10	2017-09-25 16:30:10	23:59:59	00:00:00	\N	04269531987	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 266	304	f	-1	\N	2017-09-25 16:30:10	default	ANGELASOTO	0	0
2017-09-25 16:32:44	2017-09-25 16:32:44	2017-09-25 16:32:44	23:59:59	00:00:00	\N	04123705235	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 267	305	f	-1	\N	2017-09-25 16:32:44	default	ERIKAMANTILLA	0	0
2017-09-25 16:37:32	2017-09-25 16:37:32	2017-09-25 16:37:32	23:59:59	00:00:00	\N	04268686209	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 268	306	f	-1	\N	2017-09-25 16:37:32	default	ANGELASOTO	0	0
2017-09-25 16:40:12	2017-09-25 16:40:12	2017-09-25 16:40:12	23:59:59	00:00:00	\N	04261218804	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 269	307	f	-1	\N	2017-09-25 16:40:12	default	lina	0	0
2017-09-25 16:42:15	2017-09-25 16:42:15	2017-09-25 16:42:15	23:59:59	00:00:00	\N	04141586446	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 270	308	f	-1	\N	2017-09-25 16:42:15	default	ANGELASOTO	0	0
2017-09-26 08:14:30	2017-09-26 08:14:30	2017-09-26 08:14:30	23:59:59	00:00:00	\N	04168226508	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12061	309	f	-1	\N	2017-09-26 08:14:30	default	Olarmelina	0	0
2017-09-26 08:33:26	2017-09-26 08:33:26	2017-09-26 08:33:26	23:59:59	00:00:00	\N	04260359326	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12062	310	f	-1	\N	2017-09-26 08:33:26	default	Olarmelina	0	0
2017-09-26 09:19:15	2017-09-26 09:19:15	2017-09-26 09:19:15	23:59:59	00:00:00	\N	04261167246	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12063	311	f	-1	\N	2017-09-26 09:19:15	default	griselda	0	0
2017-09-26 09:21:57	2017-09-26 09:21:57	2017-09-26 09:21:57	23:59:59	00:00:00	\N	04268394805	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12064	312	f	-1	\N	2017-09-26 09:21:57	default	Olarmelina	0	0
2017-09-26 09:26:33	2017-09-26 09:26:33	2017-09-26 09:26:33	23:59:59	00:00:00	\N	04169192156	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 271	313	f	-1	\N	2017-09-26 09:26:33	default	ERIKAMANTILLA	0	0
2017-09-26 09:32:10	2017-09-26 09:32:10	2017-09-26 09:32:10	23:59:59	00:00:00	\N	04264124625	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12065	314	f	-1	\N	2017-09-26 09:32:10	default	griselda	0	0
2017-09-26 09:49:57	2017-09-26 09:49:57	2017-09-26 09:49:57	23:59:59	00:00:00	\N	04169565436	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 272	315	f	-1	\N	2017-09-26 09:49:57	default	GENESISLEON	0	0
2017-09-26 09:54:22	2017-09-26 09:54:22	2017-09-26 09:54:22	23:59:59	00:00:00	\N	04143523667	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12066	316	f	-1	\N	2017-09-26 09:54:22	default	Olarmelina	0	0
2017-09-26 09:56:52	2017-09-26 09:56:52	2017-09-26 09:56:52	23:59:59	00:00:00	\N	04169565436	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 273	317	f	-1	\N	2017-09-26 09:56:52	default	GENESISLEON	0	0
2017-09-26 10:10:24	2017-09-26 10:10:24	2017-09-26 10:10:24	23:59:59	00:00:00	\N	04145547091	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 274	318	f	-1	\N	2017-09-26 10:10:24	default	MARIA	0	0
2017-09-26 10:11:34	2017-09-26 10:11:34	2017-09-26 10:11:34	23:59:59	00:00:00	\N	04145491148	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 275	319	f	-1	\N	2017-09-26 10:11:34	default	ERIKAMANTILLA	0	0
2017-09-26 10:16:49	2017-09-26 10:16:49	2017-09-26 10:16:49	23:59:59	00:00:00	\N	04245956750	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12068	320	f	-1	\N	2017-09-26 10:16:49	default	douglasr	0	0
2017-09-26 10:17:12	2017-09-26 10:17:12	2017-09-26 10:17:12	23:59:59	00:00:00	\N	04128519263	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 276	321	f	-1	\N	2017-09-26 10:17:12	default	HOSTO.REIMAR	0	0
2017-09-26 10:18:44	2017-09-26 10:18:44	2017-09-26 10:18:44	23:59:59	00:00:00	\N	04245956750	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12069	322	f	-1	\N	2017-09-26 10:18:44	default	Olarmelina	0	0
2017-09-26 10:24:08	2017-09-26 10:24:08	2017-09-26 10:24:08	23:59:59	00:00:00	\N	04269509116	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12070	323	f	-1	\N	2017-09-26 10:24:08	default	Olarmelina	0	0
2017-09-26 10:30:46	2017-09-26 10:30:46	2017-09-26 10:30:46	23:59:59	00:00:00	\N	04144531177	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 278	324	f	-1	\N	2017-09-26 10:30:46	default	MARYCORDERO	0	0
2017-09-26 10:31:48	2017-09-26 10:31:48	2017-09-26 10:31:48	23:59:59	00:00:00	\N	04266830653	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 279	325	f	-1	\N	2017-09-26 10:31:48	default	LIBERON.GENESIS	0	0
2017-09-26 10:34:24	2017-09-26 10:34:24	2017-09-26 10:34:24	23:59:59	00:00:00	\N	04164010752	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12071	326	f	-1	\N	2017-09-26 10:34:24	default	jrangel	0	0
2017-09-26 10:36:52	2017-09-26 10:36:52	2017-09-26 10:36:52	23:59:59	00:00:00	\N	04161041807	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 280	327	f	-1	\N	2017-09-26 10:36:52	default	MARIA	0	0
2017-09-26 10:37:10	2017-09-26 10:37:10	2017-09-26 10:37:10	23:59:59	00:00:00	\N	04263525064	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 281	328	f	-1	\N	2017-09-26 10:37:10	default	HOSTO.REIMAR	0	0
2017-09-26 10:43:09	2017-09-26 10:43:09	2017-09-26 10:43:09	23:59:59	00:00:00	\N	04245549613	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12072	329	f	-1	\N	2017-09-26 10:43:09	default	Olarmelina	0	0
2017-09-26 10:46:00	2017-09-26 10:46:00	2017-09-26 10:46:00	23:59:59	00:00:00	\N	04145103175	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 282	330	f	-1	\N	2017-09-26 10:46:00	default	MARYCORDERO	0	0
2017-09-26 10:46:30	2017-09-26 10:46:30	2017-09-26 10:46:30	23:59:59	00:00:00	\N	04166888637	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 283	331	f	-1	\N	2017-09-26 10:46:30	default	MARIA	0	0
2017-09-26 10:46:32	2017-09-26 10:46:32	2017-09-26 10:46:32	23:59:59	00:00:00	\N	04245256924	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 284	332	f	-1	\N	2017-09-26 10:46:32	default	HOSTO.REIMAR	0	0
2017-09-26 10:46:50	2017-09-26 10:46:50	2017-09-26 10:46:50	23:59:59	00:00:00	\N	04169551859	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12073	333	f	-1	\N	2017-09-26 10:46:50	default	douglasr	0	0
2017-09-26 10:51:34	2017-09-26 10:51:34	2017-09-26 10:51:34	23:59:59	00:00:00	\N	04169551859	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12074	334	f	-1	\N	2017-09-26 10:51:34	default	douglasr	0	0
2017-09-26 10:54:39	2017-09-26 10:54:39	2017-09-26 10:54:39	23:59:59	00:00:00	\N	04166888637	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 286	335	f	-1	\N	2017-09-26 10:54:39	default	MARIA	0	0
2017-09-26 10:56:28	2017-09-26 10:56:28	2017-09-26 10:56:28	23:59:59	00:00:00	\N	04168241019	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 287	336	f	-1	\N	2017-09-26 10:56:28	default	HOSTO.REIMAR	0	0
2017-09-26 10:56:48	2017-09-26 10:56:48	2017-09-26 10:56:48	23:59:59	00:00:00	\N	04145242170	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 288	337	f	-1	\N	2017-09-26 10:56:48	default	MARYCORDERO	0	0
2017-09-26 11:02:07	2017-09-26 11:02:07	2017-09-26 11:02:07	23:59:59	00:00:00	\N	04145701261	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12075	338	f	-1	\N	2017-09-26 11:02:07	default	douglasr	0	0
2017-09-26 11:02:09	2017-09-26 11:02:09	2017-09-26 11:02:09	23:59:59	00:00:00	\N	04145701261	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12076	339	f	-1	\N	2017-09-26 11:02:09	default	douglasr	0	0
2017-09-26 11:02:10	2017-09-26 11:02:10	2017-09-26 11:02:10	23:59:59	00:00:00	\N	04145701261	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12077	340	f	-1	\N	2017-09-26 11:02:10	default	douglasr	0	0
2017-09-26 11:03:44	2017-09-26 11:03:44	2017-09-26 11:03:44	23:59:59	00:00:00	\N	04268513547	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 289	341	f	-1	\N	2017-09-26 11:03:44	default	HOSTO.REIMAR	0	0
2017-09-26 11:06:17	2017-09-26 11:06:17	2017-09-26 11:06:17	23:59:59	00:00:00	\N	04167550802	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 290	342	f	-1	\N	2017-09-26 11:06:17	default	GENESISLEON	0	0
2017-09-26 11:06:32	2017-09-26 11:06:32	2017-09-26 11:06:32	23:59:59	00:00:00	\N	04245649926	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 291	343	f	-1	\N	2017-09-26 11:06:32	default	MARIA	0	0
2017-09-26 11:13:08	2017-09-26 11:13:08	2017-09-26 11:13:08	23:59:59	00:00:00	\N	04245608501	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 292	344	f	-1	\N	2017-09-26 11:13:08	default	ERIKAMANTILLA	0	0
2017-09-26 11:14:37	2017-09-26 11:14:37	2017-09-26 11:14:37	23:59:59	00:00:00	\N	04167550802	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 293	345	f	-1	\N	2017-09-26 11:14:37	default	GENESISLEON	0	0
2017-09-26 11:19:05	2017-09-26 11:19:05	2017-09-26 11:19:05	23:59:59	00:00:00	\N	04165572389	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 294	346	f	-1	\N	2017-09-26 11:19:05	default	MARIA	0	0
2017-09-26 11:19:46	2017-09-26 11:19:46	2017-09-26 11:19:46	23:59:59	00:00:00	\N	04125279426	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12078	347	f	-1	\N	2017-09-26 11:19:46	default	douglasr	0	0
2017-09-26 11:22:21	2017-09-26 11:22:21	2017-09-26 11:22:21	23:59:59	00:00:00	\N	04125279426	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12079	348	f	-1	\N	2017-09-26 11:22:21	default	douglasr	0	0
2017-09-26 11:22:21	2017-09-26 11:22:21	2017-09-26 11:22:21	23:59:59	00:00:00	\N	04261511523	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 295	349	f	-1	\N	2017-09-26 11:22:21	default	LIBERON.GENESIS	0	0
2017-09-26 11:31:53	2017-09-26 11:31:53	2017-09-26 11:31:53	23:59:59	00:00:00	\N	04245221997	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 296	350	f	-1	\N	2017-09-26 11:31:53	default	HOSTO.REIMAR	0	0
2017-09-26 11:32:50	2017-09-26 11:32:50	2017-09-26 11:32:50	23:59:59	00:00:00	\N	04169550244	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 297	351	f	-1	\N	2017-09-26 11:32:50	default	MARIA	0	0
2017-09-26 11:33:57	2017-09-26 11:33:57	2017-09-26 11:33:57	23:59:59	00:00:00	\N	04262094611	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 298	352	f	-1	\N	2017-09-26 11:33:57	default	genesis	0	0
2017-09-26 11:36:31	2017-09-26 11:36:31	2017-09-26 11:36:31	23:59:59	00:00:00	\N	04261511523	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 299	353	f	-1	\N	2017-09-26 11:36:31	default	LIBERON.GENESIS	0	0
2017-09-26 11:37:03	2017-09-26 11:37:03	2017-09-26 11:37:03	23:59:59	00:00:00	\N	04169550244	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 300	354	f	-1	\N	2017-09-26 11:37:03	default	MARIA	0	0
2017-09-26 11:43:18	2017-09-26 11:43:18	2017-09-26 11:43:18	23:59:59	00:00:00	\N	04145073690	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 301	355	f	-1	\N	2017-09-26 11:43:18	default	HOSTO.REIMAR	0	0
2017-09-26 11:43:28	2017-09-26 11:43:28	2017-09-26 11:43:28	23:59:59	00:00:00	\N	04169731190	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 302	356	f	-1	\N	2017-09-26 11:43:28	default	GENESISLEON	0	0
2017-09-26 11:45:24	2017-09-26 11:45:24	2017-09-26 11:45:24	23:59:59	00:00:00	\N	04264783056	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 303	357	f	-1	\N	2017-09-26 11:45:24	default	genesis	0	0
2017-09-26 11:47:05	2017-09-26 11:47:05	2017-09-26 11:47:05	23:59:59	00:00:00	\N	04161593671	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 304	358	f	-1	\N	2017-09-26 11:47:05	default	ERIKAMANTILLA	0	0
2017-09-26 11:49:18	2017-09-26 11:49:18	2017-09-26 11:49:18	23:59:59	00:00:00	\N	04169731190	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 305	359	f	-1	\N	2017-09-26 11:49:18	default	GENESISLEON	0	0
2017-09-26 11:51:30	2017-09-26 11:51:30	2017-09-26 11:51:30	23:59:59	00:00:00	\N	04165130104	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 306	360	f	-1	\N	2017-09-26 11:51:30	default	LIBERON.GENESIS	0	0
2017-09-26 11:52:48	2017-09-26 11:52:48	2017-09-26 11:52:48	23:59:59	00:00:00	\N	04245375867	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 307	361	f	-1	\N	2017-09-26 11:52:48	default	MARYCORDERO	0	0
2017-09-26 11:53:26	2017-09-26 11:53:26	2017-09-26 11:53:26	23:59:59	00:00:00	\N	04125161056	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 308	362	f	-1	\N	2017-09-26 11:53:26	default	genesis	0	0
2017-09-26 11:56:44	2017-09-26 11:56:44	2017-09-26 11:56:44	23:59:59	00:00:00	\N	04169731190	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 309	363	f	-1	\N	2017-09-26 11:56:44	default	GENESISLEON	0	0
2017-09-26 11:57:46	2017-09-26 11:57:46	2017-09-26 11:57:46	23:59:59	00:00:00	\N	04269531987	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 310	364	f	-1	\N	2017-09-26 11:57:46	default	genesis	0	0
2017-09-26 12:04:42	2017-09-26 12:04:42	2017-09-26 12:04:42	23:59:59	00:00:00	\N	04161593671	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 311	365	f	-1	\N	2017-09-26 12:04:42	default	ERIKAMANTILLA	0	0
2017-09-26 12:07:44	2017-09-26 12:07:44	2017-09-26 12:07:44	23:59:59	00:00:00	\N	04167562542	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 312	366	f	-1	\N	2017-09-26 12:07:44	default	MARYCORDERO	0	0
2017-09-26 12:18:31	2017-09-26 12:18:31	2017-09-26 12:18:31	23:59:59	00:00:00	\N	04262716983	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 313	367	f	-1	\N	2017-09-26 12:18:31	default	GENESISLEON	0	0
2017-09-26 12:19:58	2017-09-26 12:19:58	2017-09-26 12:19:58	23:59:59	00:00:00	\N	04167586835	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 314	368	f	-1	\N	2017-09-26 12:19:58	default	LIBERON.GENESIS	0	0
2017-09-26 12:23:00	2017-09-26 12:23:00	2017-09-26 12:23:00	23:59:59	00:00:00	\N	04245485223	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12080	369	f	-1	\N	2017-09-26 12:23:00	default	Olarmelina	0	0
2017-09-26 12:27:18	2017-09-26 12:27:18	2017-09-26 12:27:18	23:59:59	00:00:00	\N	04263598350	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 315	370	f	-1	\N	2017-09-26 12:27:18	default	HOSTO.REIMAR	0	0
2017-09-26 12:33:50	2017-09-26 12:33:50	2017-09-26 12:33:50	23:59:59	00:00:00	\N	04263598350	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 316	371	f	-1	\N	2017-09-26 12:33:50	default	HOSTO.REIMAR	0	0
2017-09-26 12:38:21	2017-09-26 12:38:21	2017-09-26 12:38:21	23:59:59	00:00:00	\N	04161529471	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 317	372	f	-1	\N	2017-09-26 12:38:21	default	LIBERON.GENESIS	0	0
2017-09-26 12:39:57	2017-09-26 12:39:57	2017-09-26 12:39:57	23:59:59	00:00:00	\N	04245466174	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 318	373	f	-1	\N	2017-09-26 12:39:57	default	ERIKAMANTILLA	0	0
2017-09-26 12:40:06	2017-09-26 12:40:06	2017-09-26 12:40:06	23:59:59	00:00:00	\N	04262511364	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 319	374	f	-1	\N	2017-09-26 12:40:06	default	GENESISLEON	0	0
2017-09-26 12:45:39	2017-09-26 12:45:39	2017-09-26 12:45:39	23:59:59	00:00:00	\N	04245466174	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 320	375	f	-1	\N	2017-09-26 12:45:39	default	ERIKAMANTILLA	0	0
2017-09-26 12:50:48	2017-09-26 12:50:48	2017-09-26 12:50:48	23:59:59	00:00:00	\N	04261084166	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 321	376	f	-1	\N	2017-09-26 12:50:48	default	GENESISLEON	0	0
2017-09-26 13:04:51	2017-09-26 13:04:51	2017-09-26 13:04:51	23:59:59	00:00:00	\N	04262519717	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12081	377	f	-1	\N	2017-09-26 13:04:51	default	douglasr	0	0
2017-09-26 13:04:53	2017-09-26 13:04:53	2017-09-26 13:04:53	23:59:59	00:00:00	\N	04262519717	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12082	378	f	-1	\N	2017-09-26 13:04:53	default	douglasr	0	0
2017-09-26 13:07:52	2017-09-26 13:07:52	2017-09-26 13:07:52	23:59:59	00:00:00	\N	04145188666	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 322	379	f	-1	\N	2017-09-26 13:07:52	default	MARIA	0	0
2017-09-26 13:20:05	2017-09-26 13:20:05	2017-09-26 13:20:05	23:59:59	00:00:00	\N	04244411895	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 323	380	f	-1	\N	2017-09-26 13:20:05	default	MARIA	0	0
2017-09-26 13:29:58	2017-09-26 13:29:58	2017-09-26 13:29:58	23:59:59	00:00:00	\N	04145608969	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 324	381	f	-1	\N	2017-09-26 13:29:58	default	MARIA	0	0
2017-09-26 13:38:40	2017-09-26 13:38:40	2017-09-26 13:38:40	23:59:59	00:00:00	\N	04145701965	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12083	382	f	-1	\N	2017-09-26 13:38:40	default	griselda	0	0
2017-09-26 13:55:01	2017-09-26 13:55:01	2017-09-26 13:55:01	23:59:59	00:00:00	\N	04266039799	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 325	383	f	-1	\N	2017-09-26 13:55:01	default	GENESISLEON	0	0
2017-09-26 14:08:03	2017-09-26 14:08:03	2017-09-26 14:08:03	23:59:59	00:00:00	\N	04266039799	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 326	384	f	-1	\N	2017-09-26 14:08:03	default	GENESISLEON	0	0
2017-09-26 14:15:10	2017-09-26 14:15:10	2017-09-26 14:15:10	23:59:59	00:00:00	\N	04263508161	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 327	385	f	-1	\N	2017-09-26 14:15:10	default	FRANCIS	0	0
2017-09-26 14:41:54	2017-09-26 14:41:54	2017-09-26 14:41:54	23:59:59	00:00:00	\N	04165531470	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 328	386	f	-1	\N	2017-09-26 14:41:54	default	HOSTO.REIMAR	0	0
2017-09-26 15:00:20	2017-09-26 15:00:20	2017-09-26 15:00:20	23:59:59	00:00:00	\N	04245466174	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 329	387	f	-1	\N	2017-09-26 15:00:20	default	ERIKAMANTILLA	0	0
2017-09-26 15:01:52	2017-09-26 15:01:52	2017-09-26 15:01:52	23:59:59	00:00:00	\N	04262500247	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 330	388	f	-1	\N	2017-09-26 15:01:52	default	HOSTO.REIMAR	0	0
2017-09-26 15:11:23	2017-09-26 15:11:23	2017-09-26 15:11:23	23:59:59	00:00:00	\N	04166011050	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 331	389	f	-1	\N	2017-09-26 15:11:23	default	FRANCIS	0	0
2017-09-26 15:12:34	2017-09-26 15:12:34	2017-09-26 15:12:34	23:59:59	00:00:00	\N	04269345483	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 332	390	f	-1	\N	2017-09-26 15:12:34	default	MARIA	0	0
2017-09-26 15:18:28	2017-09-26 15:18:28	2017-09-26 15:18:28	23:59:59	00:00:00	\N	04121535030	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 333	391	f	-1	\N	2017-09-26 15:18:28	default	HOSTO.REIMAR	0	0
2017-09-26 15:20:34	2017-09-26 15:20:34	2017-09-26 15:20:34	23:59:59	00:00:00	\N	04140563561	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12084	392	f	-1	\N	2017-09-26 15:20:34	default	douglasr	0	0
2017-09-26 15:25:53	2017-09-26 15:25:53	2017-09-26 15:25:53	23:59:59	00:00:00	\N	04267433232	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 334	393	f	-1	\N	2017-09-26 15:25:53	default	FRANCIS	0	0
2017-09-26 15:29:18	2017-09-26 15:29:18	2017-09-26 15:29:18	23:59:59	00:00:00	\N	04245599762	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 335	394	f	-1	\N	2017-09-26 15:29:18	default	ERIKAMANTILLA	0	0
2017-09-26 15:30:43	2017-09-26 15:30:43	2017-09-26 15:30:43	23:59:59	00:00:00	\N	04268547792	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 336	395	f	-1	\N	2017-09-26 15:30:43	default	LIBERON.GENESIS	0	0
2017-09-26 15:35:52	2017-09-26 15:35:52	2017-09-26 15:35:52	23:59:59	00:00:00	\N	04264405744	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 337	396	f	-1	\N	2017-09-26 15:35:52	default	FRANCIS	0	0
2017-09-26 15:47:09	2017-09-26 15:47:09	2017-09-26 15:47:09	23:59:59	00:00:00	\N	04245599762	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 338	397	f	-1	\N	2017-09-26 15:47:09	default	LIBERON.GENESIS	0	0
2017-09-26 16:00:37	2017-09-26 16:00:37	2017-09-26 16:00:37	23:59:59	00:00:00	\N	04121550549	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 339	398	f	-1	\N	2017-09-26 16:00:37	default	ERIKAMANTILLA	0	0
2017-09-26 16:09:07	2017-09-26 16:09:07	2017-09-26 16:09:07	23:59:59	00:00:00	\N	04245687640	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 340	399	f	-1	\N	2017-09-26 16:09:07	default	ERIKAMANTILLA	0	0
2017-09-26 16:10:06	2017-09-26 16:10:06	2017-09-26 16:10:06	23:59:59	00:00:00	\N	04145488557	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 341	400	f	-1	\N	2017-09-26 16:10:06	default	FRANCIS	0	0
2017-09-26 16:14:02	2017-09-26 16:14:02	2017-09-26 16:14:02	23:59:59	00:00:00	\N	04145421421	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 342	401	f	-1	\N	2017-09-26 16:14:02	default	ERIKAMANTILLA	0	0
2017-09-26 16:20:05	2017-09-26 16:20:05	2017-09-26 16:20:05	23:59:59	00:00:00	\N	04145197667	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 343	402	f	-1	\N	2017-09-26 16:20:05	default	LIBERON.GENESIS	0	0
2017-09-26 16:26:56	2017-09-26 16:26:56	2017-09-26 16:26:56	23:59:59	00:00:00	\N	04145183882	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 344	403	f	-1	\N	2017-09-26 16:26:56	default	FRANCIS	0	0
2017-09-26 16:28:00	2017-09-26 16:28:00	2017-09-26 16:28:00	23:59:59	00:00:00	\N	04163567846	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 345	404	f	-1	\N	2017-09-26 16:28:00	default	GENESISLEON	0	0
2017-09-26 16:42:22	2017-09-26 16:42:22	2017-09-26 16:42:22	23:59:59	00:00:00	\N	04262561420	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 346	405	f	-1	\N	2017-09-26 16:42:22	default	FRANCIS	0	0
2017-09-26 16:49:09	2017-09-26 16:49:09	2017-09-26 16:49:09	23:59:59	00:00:00	\N	04263505298	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 347	406	f	-1	\N	2017-09-26 16:49:09	default	FRANCIS	0	0
2017-09-26 16:51:37	2017-09-26 16:51:37	2017-09-26 16:51:37	23:59:59	00:00:00	\N	04245599762	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 348	407	f	-1	\N	2017-09-26 16:51:37	default	HOSTO.REIMAR	0	0
2017-09-26 16:57:46	2017-09-26 16:57:46	2017-09-26 16:57:46	23:59:59	00:00:00	\N	04261564569	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 349	408	f	-1	\N	2017-09-26 16:57:46	default	ERIKAMANTILLA	0	0
2017-09-26 16:59:21	2017-09-26 16:59:21	2017-09-26 16:59:21	23:59:59	00:00:00	\N	04262727351	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 350	409	f	-1	\N	2017-09-26 16:59:21	default	FRANCIS	0	0
2017-09-26 17:10:40	2017-09-26 17:10:40	2017-09-26 17:10:40	23:59:59	00:00:00	\N	04266546685	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 351	410	f	-1	\N	2017-09-26 17:10:40	default	HOSTO.REIMAR	0	0
2017-09-26 17:35:01	2017-09-26 17:35:01	2017-09-26 17:35:01	23:59:59	00:00:00	\N	04268381748	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 352	411	f	-1	\N	2017-09-26 17:35:01	default	FRANCIS	0	0
2017-09-26 17:36:32	2017-09-26 17:36:32	2017-09-26 17:36:32	23:59:59	00:00:00	\N	04145576290	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 353	412	f	-1	\N	2017-09-26 17:36:32	default	HOSTO.REIMAR	0	0
2017-09-26 17:52:42	2017-09-26 17:52:42	2017-09-26 17:52:42	23:59:59	00:00:00	\N	04245016890	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 354	413	f	-1	\N	2017-09-26 17:52:42	default	HOSTO.REIMAR	0	0
2017-09-26 18:06:39	2017-09-26 18:06:39	2017-09-26 18:06:39	23:59:59	00:00:00	\N	04160548782	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 355	414	f	-1	\N	2017-09-26 18:06:39	default	FRANCIS	0	0
2017-09-26 18:16:39	2017-09-26 18:16:39	2017-09-26 18:16:39	23:59:59	00:00:00	\N	04262451144	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 356	415	f	-1	\N	2017-09-26 18:16:39	default	HOSTO.REIMAR	0	0
2017-09-26 18:24:11	2017-09-26 18:24:11	2017-09-26 18:24:11	23:59:59	00:00:00	\N	04269562992	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 357	416	f	-1	\N	2017-09-26 18:24:11	default	lina	0	0
2017-09-26 18:24:38	2017-09-26 18:24:38	2017-09-26 18:24:38	23:59:59	00:00:00	\N	04245599762	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 358	417	f	-1	\N	2017-09-26 18:24:38	default	HOSTO.REIMAR	0	0
2017-09-26 18:25:41	2017-09-26 18:25:41	2017-09-26 18:25:41	23:59:59	00:00:00	\N	04245599762	Default_No_Compression	\N	-1	@rafaelcalles: Su Solicitud Fue ANULADA, Para Mas Información Consulte su ticket por Internet o Visite Nuestras Oficinas.; Ticket Nro.: 358	418	f	-1	\N	2017-09-26 18:25:41	default	HOSTO.REIMAR	0	0
2017-09-26 18:43:42	2017-09-26 18:43:42	2017-09-26 18:43:42	23:59:59	00:00:00	\N	04245947057	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 360	419	f	-1	\N	2017-09-26 18:43:42	default	HOSTO.REIMAR	0	0
2017-09-26 18:47:35	2017-09-26 18:47:35	2017-09-26 18:47:35	23:59:59	00:00:00	\N	04261210197	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 361	420	f	-1	\N	2017-09-26 18:47:35	default	HOSTO.REIMAR	0	0
2017-09-26 18:47:54	2017-09-26 18:47:54	2017-09-26 18:47:54	23:59:59	00:00:00	\N	04245021087	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 362	421	f	-1	\N	2017-09-26 18:47:54	default	FRANCIS	0	0
2017-09-26 18:58:40	2017-09-26 18:58:40	2017-09-26 18:58:40	23:59:59	00:00:00	\N	04261090402	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 363	422	f	-1	\N	2017-09-26 18:58:40	default	lina	0	0
2017-09-26 19:00:14	2017-09-26 19:00:14	2017-09-26 19:00:14	23:59:59	00:00:00	\N	04268598154	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 364	423	f	-1	\N	2017-09-26 19:00:14	default	HOSTO.REIMAR	0	0
2017-09-26 19:05:22	2017-09-26 19:05:22	2017-09-26 19:05:22	23:59:59	00:00:00	\N	04128429972	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 365	424	f	-1	\N	2017-09-26 19:05:22	default	HOSTO.REIMAR	0	0
2017-09-26 19:15:59	2017-09-26 19:15:59	2017-09-26 19:15:59	23:59:59	00:00:00	\N	04269508637	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 366	425	f	-1	\N	2017-09-26 19:15:59	default	lina	0	0
2017-09-26 19:19:13	2017-09-26 19:19:13	2017-09-26 19:19:13	23:59:59	00:00:00	\N	04245149250	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 367	426	f	-1	\N	2017-09-26 19:19:13	default	FRANCIS	0	0
2017-09-26 19:38:50	2017-09-26 19:38:50	2017-09-26 19:38:50	23:59:59	00:00:00	\N	04168701029	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 369	427	f	-1	\N	2017-09-26 19:38:50	default	ERIKAMANTILLA	0	0
2017-09-26 19:39:29	2017-09-26 19:39:29	2017-09-26 19:39:29	23:59:59	00:00:00	\N	04165015357	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 370	428	f	-1	\N	2017-09-26 19:39:29	default	FRANCIS	0	0
2017-09-27 08:28:57	2017-09-27 08:28:57	2017-09-27 08:28:57	23:59:59	00:00:00	\N	04263090093	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 371	429	f	-1	\N	2017-09-27 08:28:57	default	ANGELASOTO	0	0
2017-09-27 08:35:21	2017-09-27 08:35:21	2017-09-27 08:35:21	23:59:59	00:00:00	\N	04162523291	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 372	430	f	-1	\N	2017-09-27 08:35:21	default	ANGELASOTO	0	0
2017-09-27 08:46:00	2017-09-27 08:46:00	2017-09-27 08:46:00	23:59:59	00:00:00	\N	04168598115	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12085	431	f	-1	\N	2017-09-27 08:46:00	default	Olarmelina	0	0
2017-09-27 08:53:12	2017-09-27 08:53:12	2017-09-27 08:53:12	23:59:59	00:00:00	\N	04127738714	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12086	432	f	-1	\N	2017-09-27 08:53:12	default	Olarmelina	0	0
2017-09-27 08:54:28	2017-09-27 08:54:28	2017-09-27 08:54:28	23:59:59	00:00:00	\N	04167543928	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12087	433	f	-1	\N	2017-09-27 08:54:28	default	jrangel	0	0
2017-09-27 08:55:48	2017-09-27 08:55:48	2017-09-27 08:55:48	23:59:59	00:00:00	\N	04266522561	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 373	434	f	-1	\N	2017-09-27 08:55:48	default	MARIA	0	0
2017-09-27 08:58:54	2017-09-27 08:58:54	2017-09-27 08:58:54	23:59:59	00:00:00	\N	04125279426	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12088	435	f	-1	\N	2017-09-27 08:58:54	default	douglasr	0	0
2017-09-27 08:59:23	2017-09-27 08:59:23	2017-09-27 08:59:23	23:59:59	00:00:00	\N	04268351354	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 374	436	f	-1	\N	2017-09-27 08:59:23	default	FRANCIS	0	0
2017-09-27 09:00:24	2017-09-27 09:00:24	2017-09-27 09:00:24	23:59:59	00:00:00	\N	04126618200	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 375	437	f	-1	\N	2017-09-27 09:00:24	default	lina	0	0
2017-09-27 09:04:44	2017-09-27 09:04:44	2017-09-27 09:04:44	23:59:59	00:00:00	\N	04161575531	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 376	438	f	-1	\N	2017-09-27 09:04:44	default	FRANCIS	0	0
2017-09-27 09:06:27	2017-09-27 09:06:27	2017-09-27 09:06:27	23:59:59	00:00:00	\N	04161298974	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12089	439	f	-1	\N	2017-09-27 09:06:27	default	douglasr	0	0
2017-09-27 09:09:22	2017-09-27 09:09:22	2017-09-27 09:09:22	23:59:59	00:00:00	\N	04126764700	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 377	440	f	-1	\N	2017-09-27 09:09:22	default	FRANCIS	0	0
2017-09-27 09:11:09	2017-09-27 09:11:09	2017-09-27 09:11:09	23:59:59	00:00:00	\N	04266576846	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12090	441	f	-1	\N	2017-09-27 09:11:09	default	jrangel	0	0
2017-09-27 09:13:15	2017-09-27 09:13:15	2017-09-27 09:13:15	23:59:59	00:00:00	\N	04168511126	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 378	442	f	-1	\N	2017-09-27 09:13:15	default	lina	0	0
2017-09-27 09:13:16	2017-09-27 09:13:16	2017-09-27 09:13:16	23:59:59	00:00:00	\N	04269273497	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 379	443	f	-1	\N	2017-09-27 09:13:16	default	ANGELASOTO	0	0
2017-09-27 09:19:20	2017-09-27 09:19:20	2017-09-27 09:19:20	23:59:59	00:00:00	\N	04121593780	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 380	444	f	-1	\N	2017-09-27 09:19:20	default	MARIA	0	0
2017-09-27 09:22:50	2017-09-27 09:22:50	2017-09-27 09:22:50	23:59:59	00:00:00	\N	04267366025	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12091	445	f	-1	\N	2017-09-27 09:22:50	default	Olarmelina	0	0
2017-09-27 09:24:16	2017-09-27 09:24:16	2017-09-27 09:24:16	23:59:59	00:00:00	\N	04168701029	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 381	446	f	-1	\N	2017-09-27 09:24:16	default	MARIA	0	0
2017-09-27 09:28:37	2017-09-27 09:28:37	2017-09-27 09:28:37	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 382	447	f	-1	\N	2017-09-27 09:28:37	default	ANGELASOTO	0	0
2017-09-27 09:33:30	2017-09-27 09:33:30	2017-09-27 09:33:30	23:59:59	00:00:00	\N	04245064770	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 383	448	f	-1	\N	2017-09-27 09:33:30	default	MARIA	0	0
2017-09-27 09:34:11	2017-09-27 09:34:11	2017-09-27 09:34:11	23:59:59	00:00:00	\N	04166548074	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12093	449	f	-1	\N	2017-09-27 09:34:11	default	jrangel	0	0
2017-09-27 09:34:25	2017-09-27 09:34:25	2017-09-27 09:34:25	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 384	450	f	-1	\N	2017-09-27 09:34:25	default	ANGELASOTO	0	0
2017-09-27 09:35:39	2017-09-27 09:35:39	2017-09-27 09:35:39	23:59:59	00:00:00	\N	04263160645	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 385	451	f	-1	\N	2017-09-27 09:35:39	default	FRANCIS	0	0
2017-09-27 09:39:39	2017-09-27 09:39:39	2017-09-27 09:39:39	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 386	452	f	-1	\N	2017-09-27 09:39:39	default	ANGELASOTO	0	0
2017-09-27 09:48:15	2017-09-27 09:48:15	2017-09-27 09:48:15	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 388	453	f	-1	\N	2017-09-27 09:48:15	default	ANGELASOTO	0	0
2017-09-27 09:53:55	2017-09-27 09:53:55	2017-09-27 09:53:55	23:59:59	00:00:00	\N	04149733122	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 389	454	f	-1	\N	2017-09-27 09:53:55	default	MARIA	0	0
2017-09-27 10:00:46	2017-09-27 10:00:46	2017-09-27 10:00:46	23:59:59	00:00:00	\N	04149373122	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 390	455	f	-1	\N	2017-09-27 10:00:46	default	FRANCIS	0	0
2017-09-27 10:05:19	2017-09-27 10:05:19	2017-09-27 10:05:19	23:59:59	00:00:00	\N	04269273497	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 391	456	f	-1	\N	2017-09-27 10:05:19	default	ANGELASOTO	0	0
2017-09-27 10:05:24	2017-09-27 10:05:24	2017-09-27 10:05:24	23:59:59	00:00:00	\N	04264689115	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 392	457	f	-1	\N	2017-09-27 10:05:24	default	lina	0	0
2017-09-27 10:09:20	2017-09-27 10:09:20	2017-09-27 10:09:20	23:59:59	00:00:00	\N	04269273497	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 393	458	f	-1	\N	2017-09-27 10:09:20	default	ANGELASOTO	0	0
2017-09-27 10:10:43	2017-09-27 10:10:43	2017-09-27 10:10:43	23:59:59	00:00:00	\N	04125211606	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12094	459	f	-1	\N	2017-09-27 10:10:43	default	jrangel	0	0
2017-09-27 10:10:50	2017-09-27 10:10:50	2017-09-27 10:10:50	23:59:59	00:00:00	\N	04265532380	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 394	460	f	-1	\N	2017-09-27 10:10:50	default	FRANCIS	0	0
2017-09-27 10:13:07	2017-09-27 10:13:07	2017-09-27 10:13:07	23:59:59	00:00:00	\N	04241542408	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 395	461	f	-1	\N	2017-09-27 10:13:07	default	MARYCORDERO	0	0
2017-09-27 10:15:08	2017-09-27 10:15:08	2017-09-27 10:15:08	23:59:59	00:00:00	\N	04265532380	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 396	462	f	-1	\N	2017-09-27 10:15:08	default	ANGELASOTO	0	0
2017-09-27 10:17:00	2017-09-27 10:17:00	2017-09-27 10:17:00	23:59:59	00:00:00	\N	04245792344	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 397	463	f	-1	\N	2017-09-27 10:17:00	default	HOSTO.REIMAR	0	0
2017-09-27 10:18:30	2017-09-27 10:18:30	2017-09-27 10:18:30	23:59:59	00:00:00	\N	04265159343	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 398	464	f	-1	\N	2017-09-27 10:18:30	default	FRANCIS	0	0
2017-09-27 10:22:26	2017-09-27 10:22:26	2017-09-27 10:22:26	23:59:59	00:00:00	\N	04264689115	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 399	465	f	-1	\N	2017-09-27 10:22:26	default	lina	0	0
2017-09-27 10:23:18	2017-09-27 10:23:18	2017-09-27 10:23:18	23:59:59	00:00:00	\N	04165159343	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 400	466	f	-1	\N	2017-09-27 10:23:18	default	ANGELASOTO	0	0
2017-09-27 10:25:11	2017-09-27 10:25:11	2017-09-27 10:25:11	23:59:59	00:00:00	\N	04169502876	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 401	467	f	-1	\N	2017-09-27 10:25:11	default	MARYCORDERO	0	0
2017-09-27 10:26:26	2017-09-27 10:26:26	2017-09-27 10:26:26	23:59:59	00:00:00	\N	04165159343	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 402	468	f	-1	\N	2017-09-27 10:26:26	default	ANGELASOTO	0	0
2017-09-27 10:26:26	2017-09-27 10:26:26	2017-09-27 10:26:26	23:59:59	00:00:00	\N	04245908597	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 403	469	f	-1	\N	2017-09-27 10:26:26	default	MARIA	0	0
2017-09-27 10:34:31	2017-09-27 10:34:31	2017-09-27 10:34:31	23:59:59	00:00:00	\N	04268591833	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 404	470	f	-1	\N	2017-09-27 10:34:31	default	lina	0	0
2017-09-27 10:35:00	2017-09-27 10:35:00	2017-09-27 10:35:00	23:59:59	00:00:00	\N	04143539499	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 405	471	f	-1	\N	2017-09-27 10:35:00	default	MARIA	0	0
2017-09-27 10:37:18	2017-09-27 10:37:18	2017-09-27 10:37:18	23:59:59	00:00:00	\N	04267090516	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 406	472	f	-1	\N	2017-09-27 10:37:18	default	ANGELASOTO	0	0
2017-09-27 10:37:26	2017-09-27 10:37:26	2017-09-27 10:37:26	23:59:59	00:00:00	\N	04245379338	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 407	473	f	-1	\N	2017-09-27 10:37:26	default	MARYCORDERO	0	0
2017-09-27 10:38:32	2017-09-27 10:38:32	2017-09-27 10:38:32	23:59:59	00:00:00	\N	04268591833	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 408	474	f	-1	\N	2017-09-27 10:38:32	default	lina	0	0
2017-09-27 10:44:22	2017-09-27 10:44:22	2017-09-27 10:44:22	23:59:59	00:00:00	\N	04165130104	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 409	475	f	-1	\N	2017-09-27 10:44:22	default	MARYCORDERO	0	0
2017-09-27 10:49:43	2017-09-27 10:49:43	2017-09-27 10:49:43	23:59:59	00:00:00	\N	04145174443	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 410	476	f	-1	\N	2017-09-27 10:49:43	default	HOSTO.REIMAR	0	0
2017-09-27 10:53:40	2017-09-27 10:53:40	2017-09-27 10:53:40	23:59:59	00:00:00	\N	04125045470	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 411	477	f	-1	\N	2017-09-27 10:53:40	default	ANGELASOTO	0	0
2017-09-27 10:55:36	2017-09-27 10:55:36	2017-09-27 10:55:36	23:59:59	00:00:00	\N	04266734106	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 412	478	f	-1	\N	2017-09-27 10:55:36	default	FRANCIS	0	0
2017-09-27 10:57:43	2017-09-27 10:57:43	2017-09-27 10:57:43	23:59:59	00:00:00	\N	04245265246	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 413	479	f	-1	\N	2017-09-27 10:57:43	default	MARYCORDERO	0	0
2017-09-27 10:59:06	2017-09-27 10:59:06	2017-09-27 10:59:06	23:59:59	00:00:00	\N	04264520139	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11920	480	f	-1	\N	2017-09-27 10:59:06	default	joharlys	0	0
2017-09-27 11:00:47	2017-09-27 11:00:47	2017-09-27 11:00:47	23:59:59	00:00:00	\N	04262623046	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11938	481	f	-1	\N	2017-09-27 11:00:47	default	joharlys	0	0
2017-09-27 11:02:44	2017-09-27 11:02:44	2017-09-27 11:02:44	23:59:59	00:00:00	\N	04262313736	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11933	482	f	-1	\N	2017-09-27 11:02:44	default	joharlys	0	0
2017-09-27 11:04:03	2017-09-27 11:04:03	2017-09-27 11:04:03	23:59:59	00:00:00	\N	04125045470	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 414	483	f	-1	\N	2017-09-27 11:04:03	default	ANGELASOTO	0	0
2017-09-27 11:05:32	2017-09-27 11:05:32	2017-09-27 11:05:32	23:59:59	00:00:00	\N	04263512598	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 415	484	f	-1	\N	2017-09-27 11:05:32	default	MARYCORDERO	0	0
2017-09-27 11:05:58	2017-09-27 11:05:58	2017-09-27 11:05:58	23:59:59	00:00:00	\N	04140569306	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 416	485	f	-1	\N	2017-09-27 11:05:58	default	MARIA	0	0
2017-09-27 11:08:03	2017-09-27 11:08:03	2017-09-27 11:08:03	23:59:59	00:00:00	\N	04262451144	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 417	486	f	-1	\N	2017-09-27 11:08:03	default	MARYCORDERO	0	0
2017-09-27 11:08:39	2017-09-27 11:08:39	2017-09-27 11:08:39	23:59:59	00:00:00	\N	04121527606	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 418	487	f	-1	\N	2017-09-27 11:08:39	default	lina	0	0
2017-09-27 11:11:29	2017-09-27 11:11:29	2017-09-27 11:11:29	23:59:59	00:00:00	\N	04160574648	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12095	488	f	-1	\N	2017-09-27 11:11:29	default	Olarmelina	0	0
2017-09-27 11:11:48	2017-09-27 11:11:48	2017-09-27 11:11:48	23:59:59	00:00:00	\N	04261080218	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 419	489	f	-1	\N	2017-09-27 11:11:48	default	MARYCORDERO	0	0
2017-09-27 11:11:58	2017-09-27 11:11:58	2017-09-27 11:11:58	23:59:59	00:00:00	\N	04245209456	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 420	490	f	-1	\N	2017-09-27 11:11:58	default	HOSTO.REIMAR	0	0
2017-09-27 11:12:47	2017-09-27 11:12:47	2017-09-27 11:12:47	23:59:59	00:00:00	\N	04161265684	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11945	491	f	-1	\N	2017-09-27 11:12:47	default	joharlys	0	0
2017-09-27 11:13:04	2017-09-27 11:13:04	2017-09-27 11:13:04	23:59:59	00:00:00	\N	04245168684	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12096	492	f	-1	\N	2017-09-27 11:13:04	default	douglasr	0	0
2017-09-27 11:13:52	2017-09-27 11:13:52	2017-09-27 11:13:52	23:59:59	00:00:00	\N	04263507192	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 421	493	f	-1	\N	2017-09-27 11:13:52	default	ANGELASOTO	0	0
2017-09-27 11:15:13	2017-09-27 11:15:13	2017-09-27 11:15:13	23:59:59	00:00:00	\N	04245389270	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11800	494	f	-1	\N	2017-09-27 11:15:13	default	joharlys	0	0
2017-09-27 11:16:34	2017-09-27 11:16:34	2017-09-27 11:16:34	23:59:59	00:00:00	\N	04245389270	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11777	495	f	-1	\N	2017-09-27 11:16:34	default	joharlys	0	0
2017-09-27 11:17:11	2017-09-27 11:17:11	2017-09-27 11:17:11	23:59:59	00:00:00	\N	04161212823	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 422	496	f	-1	\N	2017-09-27 11:17:11	default	MARIA	0	0
2017-09-27 11:17:39	2017-09-27 11:17:39	2017-09-27 11:17:39	23:59:59	00:00:00	\N	04245209456	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 423	497	f	-1	\N	2017-09-27 11:17:39	default	HOSTO.REIMAR	0	0
2017-09-27 11:18:18	2017-09-27 11:18:18	2017-09-27 11:18:18	23:59:59	00:00:00	\N	04245389270	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11799	498	f	-1	\N	2017-09-27 11:18:18	default	joharlys	0	0
2017-09-27 11:18:30	2017-09-27 11:18:30	2017-09-27 11:18:30	23:59:59	00:00:00	\N	04165702480	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 424	499	f	-1	\N	2017-09-27 11:18:30	default	lina	0	0
2017-09-27 11:18:43	2017-09-27 11:18:43	2017-09-27 11:18:43	23:59:59	00:00:00	\N	04263160645	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 425	500	f	-1	\N	2017-09-27 11:18:43	default	FRANCIS	0	0
2017-09-27 11:19:01	2017-09-27 11:19:01	2017-09-27 11:19:01	23:59:59	00:00:00	\N	04168054781	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 426	501	f	-1	\N	2017-09-27 11:19:01	default	MARYCORDERO	0	0
2017-09-27 11:19:31	2017-09-27 11:19:31	2017-09-27 11:19:31	23:59:59	00:00:00	\N	04262366836	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11801	502	f	-1	\N	2017-09-27 11:19:31	default	joharlys	0	0
2017-09-27 11:21:01	2017-09-27 11:21:01	2017-09-27 11:21:01	23:59:59	00:00:00	\N	04145710134	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11798	503	f	-1	\N	2017-09-27 11:21:01	default	joharlys	0	0
2017-09-27 11:21:19	2017-09-27 11:21:19	2017-09-27 11:21:19	23:59:59	00:00:00	\N	04263507192	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 427	504	f	-1	\N	2017-09-27 11:21:19	default	ANGELASOTO	0	0
2017-09-27 11:22:28	2017-09-27 11:22:28	2017-09-27 11:22:28	23:59:59	00:00:00	\N	04269510156	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11966	505	f	-1	\N	2017-09-27 11:22:28	default	joharlys	0	0
2017-09-27 11:23:45	2017-09-27 11:23:45	2017-09-27 11:23:45	23:59:59	00:00:00	\N	04262093928	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12097	506	f	-1	\N	2017-09-27 11:23:45	default	Olarmelina	0	0
2017-09-27 11:23:45	2017-09-27 11:23:45	2017-09-27 11:23:45	23:59:59	00:00:00	\N	04120559609	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11959	507	f	-1	\N	2017-09-27 11:23:45	default	joharlys	0	0
2017-09-27 11:24:47	2017-09-27 11:24:47	2017-09-27 11:24:47	23:59:59	00:00:00	\N	04160516198	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 428	508	f	-1	\N	2017-09-27 11:24:47	default	lilia	0	0
2017-09-27 11:25:00	2017-09-27 11:25:00	2017-09-27 11:25:00	23:59:59	00:00:00	\N	04169584582	Default_No_Compression	\N	-1	@castanedarivas: Su Solicitud Fue COMPLETADO con Éxito, Esperamos Haberle Podido Ayudar, Gracias Por Confiar en Nosotros.; Ticket Nro.: 11979	509	f	-1	\N	2017-09-27 11:25:00	default	joharlys	0	0
2017-09-27 11:26:56	2017-09-27 11:26:56	2017-09-27 11:26:56	23:59:59	00:00:00	\N	04161212823	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 429	510	f	-1	\N	2017-09-27 11:26:56	default	MARIA	0	0
2017-09-27 11:30:07	2017-09-27 11:30:07	2017-09-27 11:30:07	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 430	511	f	-1	\N	2017-09-27 11:30:07	default	ANGELASOTO	0	0
2017-09-27 11:31:10	2017-09-27 11:31:10	2017-09-27 11:31:10	23:59:59	00:00:00	\N	04241542408	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 431	512	f	-1	\N	2017-09-27 11:31:10	default	MARYCORDERO	0	0
2017-09-27 11:33:19	2017-09-27 11:33:19	2017-09-27 11:33:19	23:59:59	00:00:00	\N	04264781564	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 432	513	f	-1	\N	2017-09-27 11:33:19	default	ERIKAMANTILLA	0	0
2017-09-27 11:35:29	2017-09-27 11:35:29	2017-09-27 11:35:29	23:59:59	00:00:00	\N	04160516198	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 433	514	f	-1	\N	2017-09-27 11:35:29	default	lilia	0	0
2017-09-27 11:36:32	2017-09-27 11:36:32	2017-09-27 11:36:32	23:59:59	00:00:00	\N	04167500880	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12098	515	f	-1	\N	2017-09-27 11:36:32	default	Olarmelina	0	0
2017-09-27 11:37:41	2017-09-27 11:37:41	2017-09-27 11:37:41	23:59:59	00:00:00	\N	04262531051	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 434	516	f	-1	\N	2017-09-27 11:37:41	default	ANGELASOTO	0	0
2017-09-27 11:42:31	2017-09-27 11:42:31	2017-09-27 11:42:31	23:59:59	00:00:00	\N	04262531051	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 436	517	f	-1	\N	2017-09-27 11:42:31	default	ANGELASOTO	0	0
2017-09-27 11:43:09	2017-09-27 11:43:09	2017-09-27 11:43:09	23:59:59	00:00:00	\N	04165015357	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 437	518	f	-1	\N	2017-09-27 11:43:09	default	lilia	0	0
2017-09-27 11:43:44	2017-09-27 11:43:44	2017-09-27 11:43:44	23:59:59	00:00:00	\N	04169638037	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 438	519	f	-1	\N	2017-09-27 11:43:44	default	FRANCIS	0	0
2017-09-27 11:44:27	2017-09-27 11:44:27	2017-09-27 11:44:27	23:59:59	00:00:00	\N	04127725557	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 439	520	f	-1	\N	2017-09-27 11:44:27	default	ERIKAMANTILLA	0	0
2017-09-27 11:45:01	2017-09-27 11:45:01	2017-09-27 11:45:01	23:59:59	00:00:00	\N	04261542408	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 440	521	f	-1	\N	2017-09-27 11:45:01	default	MARYCORDERO	0	0
2017-09-27 11:45:31	2017-09-27 11:45:31	2017-09-27 11:45:31	23:59:59	00:00:00	\N	04262531051	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 441	522	f	-1	\N	2017-09-27 11:45:31	default	ANGELASOTO	0	0
2017-09-27 11:48:47	2017-09-27 11:48:47	2017-09-27 11:48:47	23:59:59	00:00:00	\N	04145179516	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12099	523	f	-1	\N	2017-09-27 11:48:47	default	Olarmelina	0	0
2017-09-27 11:48:50	2017-09-27 11:48:50	2017-09-27 11:48:50	23:59:59	00:00:00	\N	04264500710	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 442	524	f	-1	\N	2017-09-27 11:48:50	default	MARIA	0	0
2017-09-27 11:49:28	2017-09-27 11:49:28	2017-09-27 11:49:28	23:59:59	00:00:00	\N	04262531051	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 443	525	f	-1	\N	2017-09-27 11:49:28	default	ANGELASOTO	0	0
2017-09-27 11:50:00	2017-09-27 11:50:00	2017-09-27 11:50:00	23:59:59	00:00:00	\N	04160516198	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 444	526	f	-1	\N	2017-09-27 11:50:00	default	lilia	0	0
2017-09-27 11:52:59	2017-09-27 11:52:59	2017-09-27 11:52:59	23:59:59	00:00:00	\N	04264149448	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12100	527	f	-1	\N	2017-09-27 11:52:59	default	Olarmelina	0	0
2017-09-27 11:55:08	2017-09-27 11:55:08	2017-09-27 11:55:08	23:59:59	00:00:00	\N	04165015357	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 445	528	f	-1	\N	2017-09-27 11:55:08	default	lilia	0	0
2017-09-27 11:56:26	2017-09-27 11:56:26	2017-09-27 11:56:26	23:59:59	00:00:00	\N	04164583141	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 446	529	f	-1	\N	2017-09-27 11:56:26	default	ERIKAMANTILLA	0	0
2017-09-27 11:58:43	2017-09-27 11:58:43	2017-09-27 11:58:43	23:59:59	00:00:00	\N	04264500710	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 447	530	f	-1	\N	2017-09-27 11:58:43	default	MARIA	0	0
2017-09-27 12:04:45	2017-09-27 12:04:45	2017-09-27 12:04:45	23:59:59	00:00:00	\N	04125279426	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12101	531	f	-1	\N	2017-09-27 12:04:45	default	Olarmelina	0	0
2017-09-27 12:39:42	2017-09-27 12:39:42	2017-09-27 12:39:42	23:59:59	00:00:00	\N	04162598614	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12102	532	f	-1	\N	2017-09-27 12:39:42	default	Olarmelina	0	0
2017-09-27 13:27:03	2017-09-27 13:27:03	2017-09-27 13:27:03	23:59:59	00:00:00	\N	04162578099	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12103	533	f	-1	\N	2017-09-27 13:27:03	default	douglasr	0	0
2017-09-27 14:22:32	2017-09-27 14:22:32	2017-09-27 14:22:32	23:59:59	00:00:00	\N	04145686564	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12104	534	f	-1	\N	2017-09-27 14:22:32	default	douglasr	0	0
2017-09-27 14:35:18	2017-09-27 14:35:18	2017-09-27 14:35:18	23:59:59	00:00:00	\N	04245077484	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12105	535	f	-1	\N	2017-09-27 14:35:18	default	douglasr	0	0
2017-09-27 14:36:50	2017-09-27 14:36:50	2017-09-27 14:36:50	23:59:59	00:00:00	\N	04261542408	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 448	536	f	-1	\N	2017-09-27 14:36:50	default	MARYCORDERO	0	0
2017-09-27 14:44:43	2017-09-27 14:44:43	2017-09-27 14:44:43	23:59:59	00:00:00	\N	04245292507	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 450	537	f	-1	\N	2017-09-27 14:44:43	default	HOSTO.REIMAR	0	0
2017-09-27 14:47:39	2017-09-27 14:47:39	2017-09-27 14:47:39	23:59:59	00:00:00	\N	04125206743	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 451	538	f	-1	\N	2017-09-27 14:47:39	default	MARYCORDERO	0	0
2017-09-27 14:53:03	2017-09-27 14:53:03	2017-09-27 14:53:03	23:59:59	00:00:00	\N	04145699930	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 453	539	f	-1	\N	2017-09-27 14:53:03	default	LIBERON.GENESIS	0	0
2017-09-27 14:56:19	2017-09-27 14:56:19	2017-09-27 14:56:19	23:59:59	00:00:00	\N	04169584582	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12106	540	f	-1	\N	2017-09-27 14:56:19	default	douglasr	0	0
2017-09-27 15:01:36	2017-09-27 15:01:36	2017-09-27 15:01:36	23:59:59	00:00:00	\N	04261542408	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 454	541	f	-1	\N	2017-09-27 15:01:36	default	MARYCORDERO	0	0
2017-09-27 15:07:29	2017-09-27 15:07:29	2017-09-27 15:07:29	23:59:59	00:00:00	\N	04126760199	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 455	542	f	-1	\N	2017-09-27 15:07:29	default	FRANCIS	0	0
2017-09-27 15:09:12	2017-09-27 15:09:12	2017-09-27 15:09:12	23:59:59	00:00:00	\N	04164583141	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 456	543	f	-1	\N	2017-09-27 15:09:12	default	ERIKAMANTILLA	0	0
2017-09-27 15:12:51	2017-09-27 15:12:51	2017-09-27 15:12:51	23:59:59	00:00:00	\N	04261077790	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 457	544	f	-1	\N	2017-09-27 15:12:51	default	ANGELASOTO	0	0
2017-09-27 15:16:29	2017-09-27 15:16:29	2017-09-27 15:16:29	23:59:59	00:00:00	\N	04121546572	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 459	545	f	-1	\N	2017-09-27 15:16:29	default	LIBERON.GENESIS	0	0
2017-09-27 15:17:50	2017-09-27 15:17:50	2017-09-27 15:17:50	23:59:59	00:00:00	\N	04125089213	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 460	546	f	-1	\N	2017-09-27 15:17:50	default	HOSTO.REIMAR	0	0
2017-09-27 15:24:35	2017-09-27 15:24:35	2017-09-27 15:24:35	23:59:59	00:00:00	\N	04145270550	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 461	547	f	-1	\N	2017-09-27 15:24:35	default	MARYCORDERO	0	0
2017-09-27 15:34:04	2017-09-27 15:34:04	2017-09-27 15:34:04	23:59:59	00:00:00	\N	04145270550	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 462	548	f	-1	\N	2017-09-27 15:34:04	default	MARYCORDERO	0	0
2017-09-27 15:37:50	2017-09-27 15:37:50	2017-09-27 15:37:50	23:59:59	00:00:00	\N	04262219649	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 463	549	f	-1	\N	2017-09-27 15:37:50	default	HOSTO.REIMAR	0	0
2017-09-27 15:44:13	2017-09-27 15:44:13	2017-09-27 15:44:13	23:59:59	00:00:00	\N	04267371866	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 465	550	f	-1	\N	2017-09-27 15:44:13	default	LIBERON.GENESIS	0	0
2017-09-27 15:46:09	2017-09-27 15:46:09	2017-09-27 15:46:09	23:59:59	00:00:00	\N	04262219649	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 466	551	f	-1	\N	2017-09-27 15:46:09	default	HOSTO.REIMAR	0	0
2017-09-27 15:50:15	2017-09-27 15:50:15	2017-09-27 15:50:15	23:59:59	00:00:00	\N	04143508978	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 467	552	f	-1	\N	2017-09-27 15:50:15	default	ANGELASOTO	0	0
2017-09-27 15:50:16	2017-09-27 15:50:16	2017-09-27 15:50:16	23:59:59	00:00:00	\N	04166565971	Default_No_Compression	\N	-1	@castanedarivas: Acompáñanos este 30/7/17 a votar por la A.N.C., tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 12107	553	f	-1	\N	2017-09-27 15:50:16	default	douglasr	0	0
2017-09-27 15:55:26	2017-09-27 15:55:26	2017-09-27 15:55:26	23:59:59	00:00:00	\N	04245872516	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 468	554	f	-1	\N	2017-09-27 15:55:26	default	FRANCIS	0	0
2017-09-27 15:56:33	2017-09-27 15:56:33	2017-09-27 15:56:33	23:59:59	00:00:00	\N	04145197667	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 469	555	f	-1	\N	2017-09-27 15:56:33	default	MARYCORDERO	0	0
2017-09-27 15:57:59	2017-09-27 15:57:59	2017-09-27 15:57:59	23:59:59	00:00:00	\N	04245295227	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 470	556	f	-1	\N	2017-09-27 15:57:59	default	HOSTO.REIMAR	0	0
2017-09-27 15:59:58	2017-09-27 15:59:58	2017-09-27 15:59:58	23:59:59	00:00:00	\N	04145445750	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 471	557	f	-1	\N	2017-09-27 15:59:58	default	ANGELASOTO	0	0
2017-09-27 16:04:00	2017-09-27 16:04:00	2017-09-27 16:04:00	23:59:59	00:00:00	\N	04145049212	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 472	558	f	-1	\N	2017-09-27 16:04:00	default	MARYCORDERO	0	0
2017-09-27 16:04:45	2017-09-27 16:04:45	2017-09-27 16:04:45	23:59:59	00:00:00	\N	04145445750	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 473	559	f	-1	\N	2017-09-27 16:04:45	default	ANGELASOTO	0	0
2017-09-27 16:10:23	2017-09-27 16:10:23	2017-09-27 16:10:23	23:59:59	00:00:00	\N	04269523450	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 474	560	f	-1	\N	2017-09-27 16:10:23	default	LIBERON.GENESIS	0	0
2017-09-27 16:17:07	2017-09-27 16:17:07	2017-09-27 16:17:07	23:59:59	00:00:00	\N	04245591084	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 475	561	f	-1	\N	2017-09-27 16:17:07	default	rosimar	0	0
2017-09-27 16:17:45	2017-09-27 16:17:45	2017-09-27 16:17:45	23:59:59	00:00:00	\N	04145457429	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 476	562	f	-1	\N	2017-09-27 16:17:45	default	ANGELASOTO	0	0
2017-09-27 16:18:22	2017-09-27 16:18:22	2017-09-27 16:18:22	23:59:59	00:00:00	\N	04167505714	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 477	563	f	-1	\N	2017-09-27 16:18:22	default	LIBERON.GENESIS	0	0
2017-09-27 16:19:10	2017-09-27 16:19:10	2017-09-27 16:19:10	23:59:59	00:00:00	\N	04126745744	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 478	564	f	-1	\N	2017-09-27 16:19:10	default	ERIKAMANTILLA	0	0
2017-09-27 16:22:18	2017-09-27 16:22:18	2017-09-27 16:22:18	23:59:59	00:00:00	\N	04126745744	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 479	565	f	-1	\N	2017-09-27 16:22:18	default	ERIKAMANTILLA	0	0
2017-09-27 16:23:15	2017-09-27 16:23:15	2017-09-27 16:23:15	23:59:59	00:00:00	\N	04160313802	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 480	566	f	-1	\N	2017-09-27 16:23:15	default	MARYCORDERO	0	0
2017-09-27 16:27:13	2017-09-27 16:27:13	2017-09-27 16:27:13	23:59:59	00:00:00	\N	04263080557	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 481	567	f	-1	\N	2017-09-27 16:27:13	default	HOSTO.REIMAR	0	0
2017-09-27 16:35:49	2017-09-27 16:35:49	2017-09-27 16:35:49	23:59:59	00:00:00	\N	04245292507	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 482	568	f	-1	\N	2017-09-27 16:35:49	default	HOSTO.REIMAR	0	0
2017-09-27 16:36:13	2017-09-27 16:36:13	2017-09-27 16:36:13	23:59:59	00:00:00	\N	04269395407	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 483	569	f	-1	\N	2017-09-27 16:36:13	default	ANGELASOTO	0	0
2017-09-27 16:46:00	2017-09-27 16:46:00	2017-09-27 16:46:00	23:59:59	00:00:00	\N	04244236899	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 485	570	f	-1	\N	2017-09-27 16:46:00	default	ANGELASOTO	0	0
2017-09-27 16:50:45	2017-09-27 16:50:45	2017-09-27 16:50:45	23:59:59	00:00:00	\N	04244236899	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 486	571	f	-1	\N	2017-09-27 16:50:45	default	ANGELASOTO	0	0
2017-09-27 16:53:06	2017-09-27 16:53:06	2017-09-27 16:53:06	23:59:59	00:00:00	\N	04126618200	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 487	572	f	-1	\N	2017-09-27 16:53:06	default	lina	0	0
2017-09-27 16:53:53	2017-09-27 16:53:53	2017-09-27 16:53:53	23:59:59	00:00:00	\N	04163528210	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 488	573	f	-1	\N	2017-09-27 16:53:53	default	MARYCORDERO	0	0
2017-09-27 16:54:07	2017-09-27 16:54:07	2017-09-27 16:54:07	23:59:59	00:00:00	\N	04269558619	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 489	574	f	-1	\N	2017-09-27 16:54:07	default	rosimar	0	0
2017-09-27 16:55:40	2017-09-27 16:55:40	2017-09-27 16:55:40	23:59:59	00:00:00	\N	04149510746	Default_No_Compression	\N	-1	@rafaelcalles: tienes una Solicitud en la PORTUGUESA SOCIALISTA.; Ticket Nro.: 490	575	f	-1	\N	2017-09-27 16:55:40	default	HOSTO.REIMAR	0	0
\.


--
-- Name: outbox_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('"outbox_ID_seq"', 575, true);


--
-- Data for Name: outbox_multipart; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY outbox_multipart ("Text", "Coding", "UDH", "Class", "TextDecoded", "ID", "SequencePosition") FROM stdin;
\.


--
-- Name: outbox_multipart_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('"outbox_multipart_ID_seq"', 1, false);


--
-- Data for Name: parroquia; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY parroquia (codigo_parroquia, nombre_parroquia) FROM stdin;
1	CM.GUANARE
2	CORDOBA
3	SAN JUAN DE GUANAGUANARE
4	VIRGEN DE COROMOTO
5	SAN JOSE DE LA MONTAÑA
\.


--
-- Name: parroquia_codigo_parroquia_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('parroquia_codigo_parroquia_seq', 5, true);


--
-- Data for Name: phones; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY phones ("ID", "UpdatedInDB", "InsertIntoDB", "TimeOut", "Send", "Receive", "IMEI", "IMSI", "NetCode", "NetName", "Client", "Battery", "Signal", "Sent", "Received") FROM stdin;
\.


--
-- Data for Name: sentitems; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY sentitems ("UpdatedInDB", "InsertIntoDB", "SendingDateTime", "DeliveryDateTime", "Text", "DestinationNumber", "Coding", "UDH", "SMSCNumber", "Class", "TextDecoded", "ID", "SenderID", "SequencePosition", "Status", "StatusError", "TPMR", "RelativeValidity", "CreatorID") FROM stdin;
\.


--
-- Name: sentitems_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('"sentitems_ID_seq"', 1, false);


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY usuarios (cedula, nombre_usuario, apellido_usuario, usuario, pass, nivel_acceso, status, fecha_registro, hora_registro) FROM stdin;
17261813	kerlly	ramirez	kerlly	03db60c2331018b18c4166c1787072fe	0	1	2013-12-16	13:01:01.638657
16208669	dimas	robayo	dimas	cdaedc0fc04760e2f7e532d86b9e6c38	0	1	2013-12-16	13:02:39.001646
17261813	kerlly	ramirez	kerlly	03db60c2331018b18c4166c1787072fe	0	1	2013-12-16	13:01:01.638657
16208669	dimas	robayo	dimas	cdaedc0fc04760e2f7e532d86b9e6c38	0	1	2013-12-16	13:02:39.001646
\.


--
-- Name: cargo_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT cargo_pkey PRIMARY KEY (codigo_cargo);


--
-- Name: centro_votacion_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY centro_votacion
    ADD CONSTRAINT centro_votacion_pkey PRIMARY KEY (codigo_centro);


--
-- Name: gammu_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY gammu
    ADD CONSTRAINT gammu_pkey PRIMARY KEY ("Version");


--
-- Name: inbox_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY inbox
    ADD CONSTRAINT inbox_pkey PRIMARY KEY ("ID");


--
-- Name: militantes_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY militantes
    ADD CONSTRAINT militantes_pkey PRIMARY KEY (cedula_militante);


--
-- Name: outbox_multipart_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY outbox_multipart
    ADD CONSTRAINT outbox_multipart_pkey PRIMARY KEY ("ID", "SequencePosition");


--
-- Name: outbox_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY outbox
    ADD CONSTRAINT outbox_pkey PRIMARY KEY ("ID");


--
-- Name: parroquia_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY parroquia
    ADD CONSTRAINT parroquia_pkey PRIMARY KEY (codigo_parroquia);


--
-- Name: phones_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY phones
    ADD CONSTRAINT phones_pkey PRIMARY KEY ("IMEI");


--
-- Name: sentitems_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas; Tablespace: 
--

ALTER TABLE ONLY sentitems
    ADD CONSTRAINT sentitems_pkey PRIMARY KEY ("ID", "SequencePosition");


--
-- Name: outbox_date; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX outbox_date ON outbox USING btree ("SendingDateTime", "SendingTimeOut");


--
-- Name: outbox_sender; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX outbox_sender ON outbox USING btree ("SenderID");


--
-- Name: sentitems_date; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX sentitems_date ON sentitems USING btree ("DeliveryDateTime");


--
-- Name: sentitems_dest; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX sentitems_dest ON sentitems USING btree ("DestinationNumber");


--
-- Name: sentitems_sender; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX sentitems_sender ON sentitems USING btree ("SenderID");


--
-- Name: sentitems_tpmr; Type: INDEX; Schema: public; Owner: dimas; Tablespace: 
--

CREATE INDEX sentitems_tpmr ON sentitems USING btree ("TPMR");


--
-- Name: update_timestamp; Type: TRIGGER; Schema: public; Owner: dimas
--

CREATE TRIGGER update_timestamp BEFORE UPDATE ON inbox FOR EACH ROW EXECUTE PROCEDURE update_timestamp();


--
-- Name: update_timestamp; Type: TRIGGER; Schema: public; Owner: dimas
--

CREATE TRIGGER update_timestamp BEFORE UPDATE ON outbox FOR EACH ROW EXECUTE PROCEDURE update_timestamp();


--
-- Name: update_timestamp; Type: TRIGGER; Schema: public; Owner: dimas
--

CREATE TRIGGER update_timestamp BEFORE UPDATE ON phones FOR EACH ROW EXECUTE PROCEDURE update_timestamp();


--
-- Name: update_timestamp; Type: TRIGGER; Schema: public; Owner: dimas
--

CREATE TRIGGER update_timestamp BEFORE UPDATE ON sentitems FOR EACH ROW EXECUTE PROCEDURE update_timestamp();


--
-- Name: militantes_codigo_cargo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY militantes
    ADD CONSTRAINT militantes_codigo_cargo_fkey FOREIGN KEY (codigo_cargo) REFERENCES cargo(codigo_cargo);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

