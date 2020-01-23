--
-- PostgreSQL database dump
--

-- Dumped from database version 10.8 (Ubuntu 10.8-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.8 (Ubuntu 10.8-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: drop_actividad(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_actividad(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos actividad%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_actividad FROM actividad WHERE codigo_actividad=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM actividad Where codigo_actividad=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_actividad(integer) OWNER TO dimas;

--
-- Name: drop_banco(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_banco(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos banco%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_banco FROM banco WHERE codigo_banco=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM banco Where codigo_banco=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_banco(integer) OWNER TO dimas;

--
-- Name: drop_categoria(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_categoria(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos categorias%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_categoria FROM categorias WHERE cod_categoria=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM categorias Where cod_categoria=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_categoria(integer) OWNER TO dimas;

--
-- Name: drop_comunidad(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_comunidad(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos comunidades%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos idcom FROM comunidades WHERE idcom=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM comunidades Where idcom=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_comunidad(integer) OWNER TO dimas;

--
-- Name: drop_concepto(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_concepto(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos concepto%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_concepto FROM concepto WHERE codigo_concepto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM concepto Where codigo_concepto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_concepto(character varying) OWNER TO dimas;

--
-- Name: drop_cuenta(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_cuenta(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos cuenta%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_cuenta FROM cuenta WHERE codigo_cuenta=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM cuenta Where codigo_cuenta=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_cuenta(integer) OWNER TO dimas;

--
-- Name: drop_edo_tramite(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_edo_tramite(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos estados_tramites%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_estado_tramite FROM estados_tramites WHERE cod_estado_tramite=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM estados_tramites Where cod_estado_tramite=$1;

      RETURN 1;    

   END IF;

END$_$;


ALTER FUNCTION public.drop_edo_tramite(integer) OWNER TO dimas;

--
-- Name: drop_empresa(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_empresa(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos empresa%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos rif_empresa FROM empresa WHERE rif_empresa=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM empresa Where rif_empresa=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_empresa(character varying) OWNER TO dimas;

--
-- Name: drop_ente_publico(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_ente_publico(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos ente_publico%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos id_ente FROM ente_publico WHERE id_ente=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM ente_publico Where id_ente=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_ente_publico(integer) OWNER TO dimas;

--
-- Name: drop_gabinete(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_gabinete(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos gabinetes%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_gabinete FROM gabinetes WHERE cod_gabinete=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM gabinetes Where cod_gabinete=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_gabinete(integer) OWNER TO dimas;

--
-- Name: drop_nivel(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_nivel(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos niveles_acceso%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_nivel FROM niveles_acceso WHERE codigo_nivel=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM niveles_acceso Where codigo_nivel=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_nivel(integer) OWNER TO dimas;

--
-- Name: drop_orden(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_orden(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos ordenes%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos id_orden FROM ordenes WHERE id_orden=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM ordenes Where id_orden=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_orden(integer) OWNER TO dimas;

--
-- Name: drop_parroquia(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_parroquia(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos parroquias%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos idpar FROM parroquias WHERE idpar=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM parroquias Where idpar=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_parroquia(integer) OWNER TO dimas;

--
-- Name: drop_partido(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_partido(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos partido_politico%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos id_partido FROM partido_politico WHERE id_partido=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM partido_politico Where id_partido=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_partido(integer) OWNER TO dimas;

--
-- Name: drop_productor(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_productor(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos productor%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_rif FROM productor WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM productor Where cedula_rif=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_productor(character varying) OWNER TO dimas;

--
-- Name: drop_profesion(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_profesion(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos profesion%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos id_profesion FROM profesion WHERE id_profesion=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM profesion Where id_profesion=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_profesion(integer) OWNER TO dimas;

--
-- Name: drop_punto_cuenta(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_punto_cuenta(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos punto_cuenta%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos id_punto FROM punto_cuenta WHERE id_punto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM punto_cuenta Where id_punto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_punto_cuenta(integer) OWNER TO dimas;

--
-- Name: drop_rubro(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_rubro(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos rubro%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_rubro FROM rubro WHERE codigo_rubro=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM rubro Where codigo_rubro=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_rubro(integer) OWNER TO dimas;

--
-- Name: drop_solicitante(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_solicitante(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos solicitantes%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_rif FROM solicitantes WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM solicitantes Where cedula_rif=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_solicitante(character varying) OWNER TO dimas;

--
-- Name: drop_tipo_actividad(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_tipo_actividad(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos tipo_actividad%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_tipo FROM tipo_actividad WHERE codigo_tipo=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM tipo_actividad Where codigo_tipo=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_tipo_actividad(integer) OWNER TO dimas;

--
-- Name: drop_tipo_cuenta(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_tipo_cuenta(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

DECLARE

   variable_datos tipo_cuenta%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos codigo_tipo_cuenta FROM tipo_cuenta WHERE codigo_tipo_cuenta=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM tipo_cuenta Where codigo_tipo_cuenta=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_tipo_cuenta(integer) OWNER TO dimas;

--
-- Name: drop_tipo_solicitante(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_tipo_solicitante(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos tipo_solicitantes%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_tipo_solicitante FROM tipo_solicitantes WHERE cod_tipo_solicitante=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM tipo_solicitantes Where cod_tipo_solicitante=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_tipo_solicitante(integer) OWNER TO dimas;

--
-- Name: drop_tramite(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_tramite(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos tramites%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_tramite FROM tramites WHERE cod_tramite=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM tramites Where cod_tramite=$1;

      RETURN 1;    

   END IF;

END$_$;


ALTER FUNCTION public.drop_tramite(integer) OWNER TO dimas;

--
-- Name: drop_unidad(integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_unidad(integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos unidades%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cod_unidad FROM unidades WHERE cod_unidad=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM unidades Where cod_unidad=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_unidad(integer) OWNER TO dimas;

--
-- Name: drop_usuario(character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.drop_usuario(character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      DELETE FROM usuarios Where cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.drop_usuario(character varying) OWNER TO dimas;

--
-- Name: insert_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos empresa%ROWTYPE;

BEGIN 

   SELECT INTO datos rif_empresa FROM empresa WHERE rif_empresa=$1;

   IF NOT FOUND THEN

     INSERT INTO empresa values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20); 

     RETURN 1;

   ELSE 

      RETURN 0; 

   END IF;  

end$_$;


ALTER FUNCTION public.insert_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: insert_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos productor%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula_rif FROM productor WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     INSERT INTO productor values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text) OWNER TO dimas;

--
-- Name: insert_punto_cuenta(character varying, date, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_punto_cuenta(character varying, date, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos punto_cuenta%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula_usuario FROM punto_cuenta WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     INSERT INTO punto_cuenta values($1,$2,$3,$4); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_punto_cuenta(character varying, date, character varying, character varying) OWNER TO dimas;

--
-- Name: insert_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos solicitantes%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula_rif FROM solicitantes WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     INSERT INTO solicitantes values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint) OWNER TO dimas;

--
-- Name: insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     INSERT INTO usuarios values($1,$2,$3,$4,$5,$6,$7,$8); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer) OWNER TO dimas;

--
-- Name: insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

     datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     INSERT INTO usuarios values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10); 

     RETURN 1;

   ELSE     

      RETURN 0;    

   END IF;  	

end$_$;


ALTER FUNCTION public.insert_usuario(character varying, character varying, character varying, character varying, character varying, integer, integer, integer, integer, integer) OWNER TO dimas;

--
-- Name: unlock_factura(integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.unlock_factura(integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos factura%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos n_factura FROM factura WHERE n_factura=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE factura SET id_status=$2 WHERE n_factura=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.unlock_factura(integer, integer) OWNER TO dimas;

--
-- Name: unlock_seguimiento(character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.unlock_seguimiento(character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos concepto%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_concepto FROM concepto WHERE codigo_concepto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE concepto SET seguimiento=$2 WHERE codigo_concepto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.unlock_seguimiento(character varying, integer) OWNER TO dimas;

--
-- Name: unlock_usuario(character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.unlock_usuario(character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE

   variable_datos usuarios%ROWTYPE;

BEGIN 

   SELECT INTO variable_datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET status=$2 WHERE cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.unlock_usuario(character varying, integer) OWNER TO dimas;

--
-- Name: update_banco(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_banco(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos banco%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_banco FROM banco WHERE codigo_banco=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE banco SET nombre_banco=$2 WHERE codigo_banco=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_banco(integer, character varying) OWNER TO dimas;

--
-- Name: update_categoria(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_categoria(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos categorias%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_categoria FROM categorias WHERE cod_categoria=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE categorias SET descripcion_categoria=$2 WHERE cod_categoria=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_categoria(integer, character varying) OWNER TO dimas;

--
-- Name: update_comunidad(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_comunidad(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos comunidades%ROWTYPE; 

BEGIN 

  SELECT INTO datos idcom FROM comunidades WHERE idcom=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE comunidades SET descom=$2 WHERE idcom=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_comunidad(integer, character varying) OWNER TO dimas;

--
-- Name: update_concepto(character varying, integer, character varying, numeric, smallint, numeric, numeric); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_concepto(character varying, integer, character varying, numeric, smallint, numeric, numeric) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos concepto%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_concepto FROM concepto WHERE codigo_concepto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE concepto SET codigo_cuenta=$2, nombre_concepto=$3, costo_unitario=$4, seguimiento=$5, stock=$6, stock_minimo=$7 WHERE codigo_concepto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_concepto(character varying, integer, character varying, numeric, smallint, numeric, numeric) OWNER TO dimas;

--
-- Name: update_cuenta(integer, character varying, integer, integer, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_cuenta(integer, character varying, integer, integer, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_banco FROM banco WHERE codigo_banco=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE cuenta SET rif_empresa=$2, codigo_banco=$3,codigo_tipo_cuenta=$4,n_cuenta=$5,observacion=$6 WHERE codigo_cuenta=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_cuenta(integer, character varying, integer, integer, character varying, character varying) OWNER TO dimas;

--
-- Name: update_edo_tramite(integer, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_edo_tramite(integer, character varying, character varying, character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos estados_tramites%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_estado_tramite FROM estados_tramites WHERE cod_estado_tramite=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE estados_tramites SET siglas_estado_tramite=$2, descripcion_estado_tramite=$3, estado_tramite=$4,tipo_estado_tramite=$5 WHERE cod_estado_tramite=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_edo_tramite(integer, character varying, character varying, character varying, integer) OWNER TO dimas;

--
-- Name: update_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos empresa%ROWTYPE; 

BEGIN 

  SELECT INTO datos rif_empresa FROM empresa WHERE rif_empresa=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE empresa SET nombre_empresa=$2, nombre_administrador=$3, ciudad=$4, telefono_oficina=$5, telefono_fax=$6, pagina_web=$7, correo_electronico=$8, logo_empresa=$9, direccion_empresa=$10, siglas_empresa=$11, send_sms=$12, send_email=$13, sms_nueva_solicitud=$14, sms_programar_ticket=$15, sms_reprogramar_ticket=$16, sms_escalar_ticket=$17, sms_completar_ticket=$18, sms_cancelar_ticket=$19, sms_anular_ticket=$20 WHERE rif_empresa=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_empresa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: update_ente_publico(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_ente_publico(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos ente_publico%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_ente FROM ente_publico WHERE id_ente=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE ente_publico SET ente_publico=$2 WHERE id_ente=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_ente_publico(integer, character varying) OWNER TO dimas;

--
-- Name: update_enviar_punto(integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_enviar_punto(integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos punto_cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_punto FROM punto_cuenta WHERE id_punto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE punto_cuenta SET condicion=$2 WHERE id_punto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_enviar_punto(integer, integer) OWNER TO dimas;

--
-- Name: update_gabinete(int4, varchar)(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public."update_gabinete(int4, varchar)"(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos gabinetes%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_gabinete FROM gabinetes WHERE cod_gabinete=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE gabinetes SET gabinete=$2 WHERE cod_gabinete=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public."update_gabinete(int4, varchar)"(integer, character varying) OWNER TO dimas;

--
-- Name: update_nivel(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_nivel(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos niveles_acceso%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_nivel FROM niveles_acceso WHERE codigo_nivel=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE niveles_acceso SET nombre_nivel=$2 WHERE codigo_nivel=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_nivel(integer, character varying) OWNER TO dimas;

--
-- Name: update_notificar_orden(integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_notificar_orden(integer, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos ordenes%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_orden FROM ordenes WHERE id_orden=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE ordenes SET status_orden=$2 WHERE id_orden=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_notificar_orden(integer, integer) OWNER TO dimas;

--
-- Name: update_notificar_punto(integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_notificar_punto(integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos punto_cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_punto FROM punto_cuenta WHERE id_punto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE punto_cuenta SET condicion=$2 WHERE id_punto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_notificar_punto(integer, integer) OWNER TO dimas;

--
-- Name: update_orden(integer, character varying, character varying, date, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_orden(integer, character varying, character varying, date, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos ordenes%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_orden FROM ordenes WHERE id_orden=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE ordenes SET cedula_usuario_orden=$2,descripcion_orden=$3,fecha_culminacion=$4,prioridad=$5,status_orden=$6 WHERE id_orden=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_orden(integer, character varying, character varying, date, integer, integer) OWNER TO dimas;

--
-- Name: update_parroquia(integer, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_parroquia(integer, character varying, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos parroquias%ROWTYPE; 

BEGIN 

  SELECT INTO datos idpar FROM parroquias WHERE idpar=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE parroquias SET codest=$2,codmun=$3,codpar=$4,despar=$5 WHERE idpar=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_parroquia(integer, character varying, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: update_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos productor%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_rif FROM productor WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE productor SET idcom=$2, nombre=$3, telefono_fijo=$4, telefono_movil=$5, documento_tenencia=$6, coor_utm_norte=$7, coor_utm_este=$8, superficie_mt2=$9, posee_maquinaria=$10, posee_infra=$11, direccion=$12 WHERE cedula_rif=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_productor(character varying, integer, character varying, character varying, character varying, character varying, character varying, character varying, numeric, character varying, character varying, text) OWNER TO dimas;

--
-- Name: update_profesion(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_profesion(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos profesion%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_profesion FROM profesion WHERE id_profesion=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE profesion SET nombre_profesion=$2 WHERE id_profesion=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_profesion(integer, character varying) OWNER TO dimas;

--
-- Name: update_punto_cuenta(integer, character varying, date, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_punto_cuenta(integer, character varying, date, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos punto_cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_punto FROM punto_cuenta WHERE id_punto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE punto_cuenta SET cedula_usuario=$2, fecha_punto=$3, asunto=$4, sintesis=$5 WHERE id_punto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_punto_cuenta(integer, character varying, date, character varying, character varying) OWNER TO dimas;

--
-- Name: update_responder_orden(integer, date, character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_responder_orden(integer, date, character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos ordenes%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_orden FROM ordenes WHERE id_orden=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE ordenes SET fecha_ejecucion=$2, accion_tomada=$3, status_orden=$4 WHERE id_orden=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_responder_orden(integer, date, character varying, integer) OWNER TO dimas;

--
-- Name: update_responder_punto(integer, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_responder_punto(integer, character varying, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos punto_cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos id_punto FROM punto_cuenta WHERE id_punto=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE punto_cuenta SET instruccion=$2, decision=$3, condicion=$4 WHERE id_punto=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_responder_punto(integer, character varying, integer, integer) OWNER TO dimas;

--
-- Name: update_rubro(integer, integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_rubro(integer, integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos rubro%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_rubro FROM rubro WHERE codigo_rubro=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE rubro SET codigo_tipo=$2, descripcion=$3 WHERE codigo_rubro=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_rubro(integer, integer, character varying) OWNER TO dimas;

--
-- Name: update_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos solicitantes%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_rif FROM solicitantes WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE solicitantes SET cod_tipo_solicitante=$2, nombre_solicitante=$3, sexo_solicitante=$4, fecha_nac=$5, direccion_habitacion=$6, telefono_fijo=$7, telefono_movil=$8, email=$9, idcom=$10, empleado_publico=$11, ente_publico=$12, miembro_partido=$13, nombre_partido=$14, nombre_profesion=$15, miembro_clp=$16, miembro_ubch=$17, miembro_umujer=$18, miembro_francisco=$19, miembro_mincomuna=$20, pregonero=$21, fecha_registro_update=$22 WHERE cedula_rif=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_solicitante(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone) OWNER TO dimas;

--
-- Name: update_solicitante_ticket(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_solicitante_ticket(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos solicitantes%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_rif FROM solicitantes WHERE cedula_rif=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE solicitantes SET cod_tipo_solicitante=$2,nombre_solicitante=$3,sexo_solicitante=$4,fecha_nac=$5,direccion_habitacion=$6,telefono_fijo=$7,telefono_movil=$8,email=$9,idcom=$10, empleado_publico=$11, ente_publico=$12, miembro_partido=$13, nombre_partido=$14, nombre_profesion=$15, miembro_clp=$16, miembro_ubch=$17, miembro_umujer=$18, miembro_francisco=$19, miembro_mincomuna=$20, pregonero=$21, fecha_registro_update=$22  WHERE cedula_rif=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_solicitante_ticket(character varying, integer, character varying, character varying, character varying, text, character varying, character varying, character varying, integer, smallint, character varying, smallint, character varying, character varying, smallint, smallint, smallint, smallint, smallint, smallint, timestamp without time zone) OWNER TO dimas;

--
-- Name: update_tipo_actividad(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_tipo_actividad(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos tipo_actividad%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_tipo FROM tipo_actividad WHERE codigo_tipo=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE tipo_actividad SET descripcion=$2 WHERE codigo_tipo=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_tipo_actividad(integer, character varying) OWNER TO dimas;

--
-- Name: update_tipo_cuenta(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_tipo_cuenta(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos tipo_cuenta%ROWTYPE; 

BEGIN 

  SELECT INTO datos codigo_tipo_cuenta FROM tipo_cuenta WHERE codigo_tipo_cuenta=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE tipo_cuenta SET nombre_tipo_cuenta=$2 WHERE codigo_tipo_cuenta=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_tipo_cuenta(integer, character varying) OWNER TO dimas;

--
-- Name: update_tipo_solicitante(integer, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_tipo_solicitante(integer, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos tipo_solicitantes%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_tipo_solicitante FROM tipo_solicitantes WHERE cod_tipo_solicitante=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE tipo_solicitantes SET descripcion_tipo_solicitante=$2 WHERE cod_tipo_solicitante=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_tipo_solicitante(integer, character varying) OWNER TO dimas;

--
-- Name: update_tramite(integer, integer, character varying, text, integer, integer, numeric, numeric, integer, integer, character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_tramite(integer, integer, character varying, text, integer, integer, numeric, numeric, integer, integer, character varying, character varying, text) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos tramites%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_tramite FROM tramites WHERE cod_tramite=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE tramites SET cod_categoria=$2, nombre_tramite=$3, descripcion_tramite=$4,cod_unidad=$5,cod_tipo_solicitante=$6,costo_regular=$7,costo_habilitado=$8,entrega_regular=$9,entrega_habilitada=$10,horario_consignacion=$11,horario_entrega=$12,observaciones=$13 WHERE cod_tramite=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_tramite(integer, integer, character varying, text, integer, integer, numeric, numeric, integer, integer, character varying, character varying, text) OWNER TO dimas;

--
-- Name: update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos unidades%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_unidad FROM unidades WHERE cod_unidad=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE unidades SET siglas_unidad=$2,nombre_unidad=$3,responsable_unidad=$4,cargo_responsable=$5,direccion_unidad=$6,telefono_1=$7,telefono_2=$8,email_unidad=$9,horario_unidad=$10 WHERE cod_unidad=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying) OWNER TO dimas;

--
-- Name: update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos unidades%ROWTYPE; 

BEGIN 

  SELECT INTO datos cod_unidad FROM unidades WHERE cod_unidad=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE unidades SET siglas_unidad=$2,nombre_unidad=$3,responsable_unidad=$4,cargo_responsable=$5,direccion_unidad=$6,telefono_1=$7,telefono_2=$8,email_unidad=$9,horario_unidad=$10,cod_gabinete=$11 WHERE cod_unidad=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_unidad(integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, integer) OWNER TO dimas;

--
-- Name: update_usuario(character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_usuario(character varying, character varying, character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos usuarios%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET nombre_usuario=$2, apellido_usuario=$3,  cod_unidad=$4 WHERE cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_usuario(character varying, character varying, character varying, integer) OWNER TO dimas;

--
-- Name: update_usuario(character varying, character varying, character varying, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_usuario(character varying, character varying, character varying, integer, integer, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos usuarios%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET nombre_usuario=$2, apellido_usuario=$3, cod_unidad=$4, solicitar_punto=$5, recibir_orden=$6 WHERE cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_usuario(character varying, character varying, character varying, integer, integer, integer) OWNER TO dimas;

--
-- Name: update_usuario_clave(character varying, character varying); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_usuario_clave(character varying, character varying) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos usuarios%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET pass=$2 WHERE cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_usuario_clave(character varying, character varying) OWNER TO dimas;

--
-- Name: update_usuario_nivel(character varying, integer); Type: FUNCTION; Schema: public; Owner: dimas
--

CREATE FUNCTION public.update_usuario_nivel(character varying, integer) RETURNS smallint
    LANGUAGE plpgsql
    AS $_$DECLARE  

   datos usuarios%ROWTYPE; 

BEGIN 

  SELECT INTO datos cedula_usuario FROM usuarios WHERE cedula_usuario=$1;

   IF NOT FOUND THEN

     RETURN 0;

   ELSE

      UPDATE usuarios SET nivel_acceso=$2 WHERE cedula_usuario=$1;

      RETURN 1;    

   END IF;  	

end$_$;


ALTER FUNCTION public.update_usuario_nivel(character varying, integer) OWNER TO dimas;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: categorias; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.categorias (
    cod_categoria integer NOT NULL,
    descripcion_categoria character varying(100),
    status_categoria smallint DEFAULT 1,
    status_categoria_online smallint DEFAULT 1
);


ALTER TABLE public.categorias OWNER TO dimas;

--
-- Name: categoria_cod_categoria_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.categoria_cod_categoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_cod_categoria_seq OWNER TO dimas;

--
-- Name: categoria_cod_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.categoria_cod_categoria_seq OWNED BY public.categorias.cod_categoria;


--
-- Name: comunidades; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.comunidades (
    idcom integer NOT NULL,
    codest character varying(5) NOT NULL,
    codmun character varying(5) NOT NULL,
    codpar character varying(5) NOT NULL,
    codcom character varying(5) NOT NULL,
    descom character varying(100),
    n_familia integer,
    centro_acopio character varying(100),
    jefe_comunidad character varying(12)
);


ALTER TABLE public.comunidades OWNER TO dimas;

--
-- Name: comunidades_idcom_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.comunidades_idcom_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comunidades_idcom_seq OWNER TO dimas;

--
-- Name: comunidades_idcom_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.comunidades_idcom_seq OWNED BY public.comunidades.idcom;


--
-- Name: conf_unidad; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.conf_unidad (
    id integer NOT NULL,
    unidad character varying(50) NOT NULL,
    descripcion character varying(250) NOT NULL,
    siglas character varying(5) NOT NULL
);


ALTER TABLE public.conf_unidad OWNER TO dimas;

--
-- Name: conf_unidad_id_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.conf_unidad_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.conf_unidad_id_seq OWNER TO dimas;

--
-- Name: conf_unidad_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.conf_unidad_id_seq OWNED BY public.conf_unidad.id;


--
-- Name: denuncia; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.denuncia (
    cod_denuncia integer NOT NULL,
    denuncia character varying NOT NULL
);


ALTER TABLE public.denuncia OWNER TO dimas;

--
-- Name: denuncia_cod_denuncia_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.denuncia_cod_denuncia_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.denuncia_cod_denuncia_seq OWNER TO dimas;

--
-- Name: denuncia_cod_denuncia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.denuncia_cod_denuncia_seq OWNED BY public.denuncia.cod_denuncia;


--
-- Name: detalle_puntoc_cod_detalle_tecket_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.detalle_puntoc_cod_detalle_tecket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_puntoc_cod_detalle_tecket_seq OWNER TO dimas;

--
-- Name: detalle_solvencia_cod_detalle_tecket_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.detalle_solvencia_cod_detalle_tecket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_solvencia_cod_detalle_tecket_seq OWNER TO dimas;

--
-- Name: detalle_ticket_cod_detalle_ticket_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.detalle_ticket_cod_detalle_ticket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_ticket_cod_detalle_ticket_seq OWNER TO dimas;

--
-- Name: detalles_ticket; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.detalles_ticket (
    cod_detalle_ticket integer DEFAULT nextval('public.detalle_ticket_cod_detalle_ticket_seq'::regclass) NOT NULL,
    cod_estado_tramite integer DEFAULT 2 NOT NULL,
    cod_ticket integer,
    cod_unidad integer,
    fecha_registro timestamp with time zone DEFAULT now(),
    fecha_cita_programada date,
    hora_cita_programada time with time zone,
    fecha_atencion date,
    hora_atencion time with time zone,
    situacion_actual text,
    actuacion text,
    monto_autorizado numeric(12,2) DEFAULT 0.00,
    observaciones text,
    fecha_registro_update timestamp with time zone DEFAULT now(),
    user_login character varying(50),
    sigla character varying
);


ALTER TABLE public.detalles_ticket OWNER TO dimas;

--
-- Name: TABLE detalles_ticket; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE public.detalles_ticket IS 'Vitacora de Ticket de atención';


--
-- Name: deuda_hidrologica; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.deuda_hidrologica (
    id_deuda integer NOT NULL,
    cedula_rif character varying NOT NULL,
    n_cliente character varying NOT NULL,
    fecha_emision date NOT NULL,
    monto_factura numeric NOT NULL,
    pagado numeric,
    fecha_pago date,
    status_deuda smallint DEFAULT 0 NOT NULL,
    n_factura character varying NOT NULL,
    periodo_facturado character varying,
    id_pago character varying,
    id_referencia character varying
);


ALTER TABLE public.deuda_hidrologica OWNER TO dimas;

--
-- Name: deuda_hidrologica_id_deuda_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.deuda_hidrologica_id_deuda_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deuda_hidrologica_id_deuda_seq OWNER TO dimas;

--
-- Name: deuda_hidrologica_id_deuda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.deuda_hidrologica_id_deuda_seq OWNED BY public.deuda_hidrologica.id_deuda;


--
-- Name: em_informe_semanal; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.em_informe_semanal (
    id_informe integer NOT NULL,
    nombre_informe character varying NOT NULL,
    semana_informe character varying NOT NULL,
    mes_informe character varying NOT NULL,
    path character varying,
    id_estado_mayor integer
);


ALTER TABLE public.em_informe_semanal OWNER TO dimas;

--
-- Name: em_Informe_semanal_id_informe_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public."em_Informe_semanal_id_informe_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."em_Informe_semanal_id_informe_seq" OWNER TO dimas;

--
-- Name: em_Informe_semanal_id_informe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public."em_Informe_semanal_id_informe_seq" OWNED BY public.em_informe_semanal.id_informe;


--
-- Name: em_ejecutado; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.em_ejecutado (
    id_ejecutado integer NOT NULL,
    id_planificacion integer NOT NULL,
    meta_ejecutada character varying NOT NULL,
    monto_ejecutado money DEFAULT 0,
    status_ejecutado smallint DEFAULT 0,
    fecha_registro date DEFAULT now()
);


ALTER TABLE public.em_ejecutado OWNER TO dimas;

--
-- Name: em_ejecutado_id_ejecutado_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.em_ejecutado_id_ejecutado_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.em_ejecutado_id_ejecutado_seq OWNER TO dimas;

--
-- Name: em_ejecutado_id_ejecutado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.em_ejecutado_id_ejecutado_seq OWNED BY public.em_ejecutado.id_ejecutado;


--
-- Name: em_planificacion; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.em_planificacion (
    id_planificacion integer NOT NULL,
    lo_discutido character varying NOT NULL,
    posible_solucion character varying NOT NULL,
    fecha_ejecucion date NOT NULL,
    responsable character varying(80) NOT NULL,
    unidad_medida character varying(80) NOT NULL,
    meta_planificada character varying(20) NOT NULL,
    monto_estimado money DEFAULT 0 NOT NULL,
    id_estado_mayor integer,
    status_planificacion smallint DEFAULT 0
);


ALTER TABLE public.em_planificacion OWNER TO dimas;

--
-- Name: em_planificacion_id_planificacion_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.em_planificacion_id_planificacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.em_planificacion_id_planificacion_seq OWNER TO dimas;

--
-- Name: em_planificacion_id_planificacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.em_planificacion_id_planificacion_seq OWNED BY public.em_planificacion.id_planificacion;


--
-- Name: empresa; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.empresa (
    rif_empresa character varying(12) NOT NULL,
    nombre_empresa character varying(200) NOT NULL,
    nombre_administrador character varying(20) NOT NULL,
    ciudad character varying(20) NOT NULL,
    telefono_oficina character varying(20) NOT NULL,
    telefono_fax character varying(20),
    pagina_web character varying(30),
    correo_electronico character varying(30),
    logo_empresa character varying(30) NOT NULL,
    direccion_empresa character varying(100) NOT NULL,
    siglas_empresa character varying(30),
    send_sms character varying,
    send_email character varying,
    sms_nueva_solicitud character varying(140),
    sms_programar_ticket character varying(140),
    sms_reprogramar_ticket character varying(140),
    sms_escalar_ticket character varying(140),
    sms_completar_ticket character varying(140),
    sms_cancelar_ticket character varying(140),
    sms_anular_ticket character varying(140),
    sms_notificar_orden character varying(160),
    sms_responder_orden character varying(160),
    sms_nuevo_punto character varying(160),
    sms_notificar_punto character varying(160)
);


ALTER TABLE public.empresa OWNER TO dimas;

--
-- Name: TABLE empresa; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE public.empresa IS 'tabla en la que se almacena los datos de la empresa que usa el sistema.';


--
-- Name: ente_publico; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.ente_publico (
    id_ente integer NOT NULL,
    ente_publico character varying
);


ALTER TABLE public.ente_publico OWNER TO dimas;

--
-- Name: ente_publico_id_ente_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.ente_publico_id_ente_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ente_publico_id_ente_seq OWNER TO dimas;

--
-- Name: ente_publico_id_ente_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.ente_publico_id_ente_seq OWNED BY public.ente_publico.id_ente;


--
-- Name: estado_mayor; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.estado_mayor (
    id_estado_mayor integer NOT NULL,
    nombre_estado_mayor character varying NOT NULL,
    descripcion character varying,
    fecha_registro date DEFAULT now(),
    cedula_res_regional character varying NOT NULL,
    cedula_res_nacional character varying
);


ALTER TABLE public.estado_mayor OWNER TO dimas;

--
-- Name: estado_mayor_id_estado_mayor_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.estado_mayor_id_estado_mayor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_mayor_id_estado_mayor_seq OWNER TO dimas;

--
-- Name: estado_mayor_id_estado_mayor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.estado_mayor_id_estado_mayor_seq OWNED BY public.estado_mayor.id_estado_mayor;


--
-- Name: estados; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.estados (
    idest integer NOT NULL,
    codest character varying(5) NOT NULL,
    desest character varying(100)
);


ALTER TABLE public.estados OWNER TO dimas;

--
-- Name: estados_idest_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.estados_idest_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estados_idest_seq OWNER TO dimas;

--
-- Name: estados_idest_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.estados_idest_seq OWNED BY public.estados.idest;


--
-- Name: estados_tramites; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.estados_tramites (
    cod_estado_tramite integer NOT NULL,
    estado_tramite character varying(10),
    siglas_estado_tramite character varying(10),
    descripcion_estado_tramite character varying(100),
    tipo_estado_tramite integer
);


ALTER TABLE public.estados_tramites OWNER TO dimas;

--
-- Name: estados_tramite_cod_estado_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.estados_tramite_cod_estado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estados_tramite_cod_estado_seq OWNER TO dimas;

--
-- Name: estados_tramite_cod_estado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.estados_tramite_cod_estado_seq OWNED BY public.estados_tramites.cod_estado_tramite;


--
-- Name: municipios; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.municipios (
    idmun integer NOT NULL,
    codest character varying(5) NOT NULL,
    codmun character varying(5) NOT NULL,
    desmun character varying(100)
);


ALTER TABLE public.municipios OWNER TO dimas;

--
-- Name: municipios_idmun_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.municipios_idmun_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.municipios_idmun_seq OWNER TO dimas;

--
-- Name: municipios_idmun_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.municipios_idmun_seq OWNED BY public.municipios.idmun;


--
-- Name: niveles_acceso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.niveles_acceso (
    codigo_nivel integer NOT NULL,
    nombre_nivel character varying(50) NOT NULL
);


ALTER TABLE public.niveles_acceso OWNER TO postgres;

--
-- Name: ordenes; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.ordenes (
    id_orden integer NOT NULL,
    cedula_usuario_orden character varying NOT NULL,
    descripcion_orden character varying(250) NOT NULL,
    fecha_registro date DEFAULT now() NOT NULL,
    fecha_culminacion date NOT NULL,
    fecha_ejecucion date,
    prioridad integer NOT NULL,
    status_orden integer NOT NULL,
    accion_tomada character varying(250),
    name_file_upload character varying
);


ALTER TABLE public.ordenes OWNER TO dimas;

--
-- Name: ordenes_id_orden_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.ordenes_id_orden_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ordenes_id_orden_seq OWNER TO dimas;

--
-- Name: ordenes_id_orden_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.ordenes_id_orden_seq OWNED BY public.ordenes.id_orden;


--
-- Name: parroquias; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.parroquias (
    idpar integer NOT NULL,
    codest character varying(5) NOT NULL,
    codmun character varying(5) NOT NULL,
    codpar character varying(5) NOT NULL,
    despar character varying(100)
);


ALTER TABLE public.parroquias OWNER TO dimas;

--
-- Name: parroquias_idpar_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.parroquias_idpar_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parroquias_idpar_seq OWNER TO dimas;

--
-- Name: parroquias_idpar_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.parroquias_idpar_seq OWNED BY public.parroquias.idpar;


--
-- Name: partido_politico; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.partido_politico (
    id_partido integer NOT NULL,
    partido_politico character varying
);


ALTER TABLE public.partido_politico OWNER TO dimas;

--
-- Name: partido_politico_id_partido_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.partido_politico_id_partido_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partido_politico_id_partido_seq OWNER TO dimas;

--
-- Name: partido_politico_id_partido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.partido_politico_id_partido_seq OWNED BY public.partido_politico.id_partido;


--
-- Name: peajes; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.peajes (
    id_peaje integer NOT NULL,
    cedula_rif character varying NOT NULL,
    fecha_operacion date DEFAULT now() NOT NULL,
    tipo_operacion character varying NOT NULL,
    monto_operacion numeric NOT NULL
);


ALTER TABLE public.peajes OWNER TO dimas;

--
-- Name: peajes_id_peaje_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.peajes_id_peaje_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.peajes_id_peaje_seq OWNER TO dimas;

--
-- Name: peajes_id_peaje_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.peajes_id_peaje_seq OWNED BY public.peajes.id_peaje;


--
-- Name: permisos; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.permisos (
    cedula_usuario character varying NOT NULL,
    recibir_orden smallint DEFAULT 0 NOT NULL,
    solicitar_punto smallint DEFAULT 0 NOT NULL,
    administra_pago_hidrologica smallint DEFAULT 0 NOT NULL,
    modifica_ticket_completados smallint DEFAULT 0 NOT NULL,
    visualiza_estadisticas smallint DEFAULT 0 NOT NULL,
    mensajeria_masiva smallint DEFAULT 0 NOT NULL,
    visualiza_reportes smallint DEFAULT 0 NOT NULL,
    visualiza_herramientas smallint DEFAULT 0 NOT NULL,
    genera_ordenes smallint DEFAULT 0 NOT NULL,
    administrar_punto smallint DEFAULT 0 NOT NULL,
    configurar_sistema smallint DEFAULT 0 NOT NULL,
    usuarios_sistema smallint DEFAULT 0 NOT NULL,
    estados_tramites smallint DEFAULT 0 NOT NULL,
    categorias smallint DEFAULT 0 NOT NULL,
    unidades smallint DEFAULT 0 NOT NULL,
    tipo_solicitantes smallint DEFAULT 0 NOT NULL,
    comunidades smallint DEFAULT 0 NOT NULL,
    profesiones smallint DEFAULT 0 NOT NULL,
    entes_publicos smallint DEFAULT 0 NOT NULL,
    partidos_politicos smallint DEFAULT 0 NOT NULL,
    mis_archivos smallint DEFAULT 1 NOT NULL,
    pagos_servicios smallint DEFAULT 1 NOT NULL,
    atencion_portugueseno smallint DEFAULT 0 NOT NULL,
    genera_solicitudes smallint DEFAULT 0 NOT NULL,
    registra_solicitantes smallint DEFAULT 0 NOT NULL,
    administra_estado_mayor smallint DEFAULT 0 NOT NULL,
    gestiona_estado_mayor smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.permisos OWNER TO dimas;

--
-- Name: TABLE permisos; Type: COMMENT; Schema: public; Owner: dimas
--

COMMENT ON TABLE public.permisos IS 'tabla de almacenamientos de permisos por usuarios';


--
-- Name: permisos_visualiza_herramientas_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.permisos_visualiza_herramientas_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permisos_visualiza_herramientas_seq OWNER TO dimas;

--
-- Name: permisos_visualiza_herramientas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.permisos_visualiza_herramientas_seq OWNED BY public.permisos.visualiza_herramientas;


--
-- Name: profesion; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.profesion (
    id_profesion integer NOT NULL,
    nombre_profesion character varying NOT NULL
);


ALTER TABLE public.profesion OWNER TO dimas;

--
-- Name: profesion_id_profesion_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.profesion_id_profesion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profesion_id_profesion_seq OWNER TO dimas;

--
-- Name: profesion_id_profesion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.profesion_id_profesion_seq OWNED BY public.profesion.id_profesion;


--
-- Name: punto_cuenta; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.punto_cuenta (
    cedula_usuario character varying NOT NULL,
    fecha_punto date NOT NULL,
    asunto character varying(400) NOT NULL,
    sintesis character varying(800) NOT NULL,
    instruccion character varying,
    decision integer,
    condicion integer,
    name_file_upload character varying,
    id_punto integer NOT NULL
);


ALTER TABLE public.punto_cuenta OWNER TO dimas;

--
-- Name: punto_cuenta_id_punto_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.punto_cuenta_id_punto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.punto_cuenta_id_punto_seq OWNER TO dimas;

--
-- Name: punto_cuenta_id_punto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.punto_cuenta_id_punto_seq OWNED BY public.punto_cuenta.id_punto;


--
-- Name: solicitantes; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.solicitantes (
    cedula_rif character varying(12) NOT NULL,
    cod_tipo_solicitante integer,
    nombre_solicitante character varying(50),
    sexo_solicitante character varying(1),
    fecha_nac character varying(10),
    direccion_habitacion text,
    telefono_fijo character varying(15),
    telefono_movil character varying(15),
    email character varying(50),
    idcom integer,
    empleado_publico smallint,
    ente_publico character varying,
    miembro_partido smallint,
    nombre_partido character varying,
    nombre_profesion character varying,
    miembro_clp smallint,
    miembro_ubch smallint,
    miembro_umujer smallint,
    miembro_francisco smallint,
    miembro_mincomuna smallint,
    pregonero smallint,
    fecha_registro timestamp without time zone DEFAULT now(),
    fecha_registro_update timestamp without time zone DEFAULT now(),
    id bigint NOT NULL
);


ALTER TABLE public.solicitantes OWNER TO dimas;

--
-- Name: solicitantes_id_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.solicitantes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitantes_id_seq OWNER TO dimas;

--
-- Name: solicitantes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.solicitantes_id_seq OWNED BY public.solicitantes.id;


--
-- Name: ticket; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.ticket (
    cod_ticket integer NOT NULL,
    cedula_rif character varying(12) NOT NULL,
    cod_estado_tramite integer DEFAULT 2 NOT NULL,
    cod_tramite integer,
    fecha_registro timestamp without time zone DEFAULT now(),
    persona_contacto_dep character varying(100),
    descripcion_ticket text,
    monto_solicitud numeric(12,2) DEFAULT 0.00,
    prioridad_ticket integer DEFAULT 1,
    cod_subticket integer,
    respuesta smallint DEFAULT 0 NOT NULL,
    fecha_registro_update timestamp without time zone DEFAULT now(),
    online smallint DEFAULT 0,
    declaracion smallint DEFAULT 0,
    user_login character varying(50),
    name_file_upload character varying(50),
    id_vehiculo integer,
    siglas character varying DEFAULT 'P'::bpchar NOT NULL
);


ALTER TABLE public.ticket OWNER TO dimas;

--
-- Name: ticket_cod_ticket_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.ticket_cod_ticket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_cod_ticket_seq OWNER TO dimas;

--
-- Name: ticket_cod_ticket_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.ticket_cod_ticket_seq OWNED BY public.ticket.cod_ticket;


--
-- Name: tipo_solicitantes; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.tipo_solicitantes (
    cod_tipo_solicitante integer NOT NULL,
    descripcion_tipo_solicitante character varying(100)
);


ALTER TABLE public.tipo_solicitantes OWNER TO dimas;

--
-- Name: tipo_solicitante_cod_tipo_solicitante_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.tipo_solicitante_cod_tipo_solicitante_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_solicitante_cod_tipo_solicitante_seq OWNER TO dimas;

--
-- Name: tipo_solicitante_cod_tipo_solicitante_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.tipo_solicitante_cod_tipo_solicitante_seq OWNED BY public.tipo_solicitantes.cod_tipo_solicitante;


--
-- Name: tramites; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.tramites (
    cod_tramite integer NOT NULL,
    cod_categoria integer,
    nombre_tramite character varying(100),
    descripcion_tramite text,
    cod_unidad integer,
    cod_tipo_solicitante integer,
    costo_regular numeric(10,2),
    costo_habilitado numeric(10,2),
    entrega_regular integer,
    entrega_habilitada integer,
    horario_consignacion character varying(200),
    horario_entrega character varying(200),
    observaciones text,
    fecha_registro_update timestamp with time zone DEFAULT now() NOT NULL,
    status_tramite smallint DEFAULT 1,
    status_tramite_online smallint DEFAULT 1
);


ALTER TABLE public.tramites OWNER TO dimas;

--
-- Name: tramite_cod_tramite_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.tramite_cod_tramite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tramite_cod_tramite_seq OWNER TO dimas;

--
-- Name: tramite_cod_tramite_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.tramite_cod_tramite_seq OWNED BY public.tramites.cod_tramite;


--
-- Name: unidades; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.unidades (
    cod_unidad integer NOT NULL,
    siglas_unidad character varying(50),
    nombre_unidad character varying(50),
    responsable_unidad character varying(50),
    cargo_responsable character varying(50),
    direccion_unidad character varying(100),
    telefono_1 character varying(15),
    telefono_2 character varying(15),
    email_unidad character varying(50),
    horario_unidad character varying(100),
    status_unidad smallint DEFAULT 1
);


ALTER TABLE public.unidades OWNER TO dimas;

--
-- Name: unidades_cod_unidad_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.unidades_cod_unidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidades_cod_unidad_seq OWNER TO dimas;

--
-- Name: unidades_cod_unidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dimas
--

ALTER SEQUENCE public.unidades_cod_unidad_seq OWNED BY public.unidades.cod_unidad;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: dimas
--

CREATE TABLE public.usuarios (
    cedula_usuario character varying NOT NULL,
    nombre_usuario character varying(60) NOT NULL,
    apellido_usuario character varying(60) NOT NULL,
    usuario character varying(50) NOT NULL,
    pass character varying(50) NOT NULL,
    nivel_acceso integer NOT NULL,
    status integer NOT NULL,
    cod_unidad integer,
    fecha_registro timestamp without time zone DEFAULT now(),
    fecha_ultimoacceso timestamp without time zone DEFAULT now(),
    foto character varying DEFAULT 'default'::character varying,
    fecha_logout timestamp without time zone,
    status_login character varying(5),
    solicitar_punto integer DEFAULT 0,
    recibir_orden integer DEFAULT 0,
    email_usuario character varying,
    telefono_movil character varying,
    id_estado_mayor integer
);


ALTER TABLE public.usuarios OWNER TO dimas;

--
-- Name: visitcounter_id_seq; Type: SEQUENCE; Schema: public; Owner: dimas
--

CREATE SEQUENCE public.visitcounter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.visitcounter_id_seq OWNER TO dimas;

--
-- Name: categorias cod_categoria; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.categorias ALTER COLUMN cod_categoria SET DEFAULT nextval('public.categoria_cod_categoria_seq'::regclass);


--
-- Name: comunidades idcom; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.comunidades ALTER COLUMN idcom SET DEFAULT nextval('public.comunidades_idcom_seq'::regclass);


--
-- Name: conf_unidad id; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.conf_unidad ALTER COLUMN id SET DEFAULT nextval('public.conf_unidad_id_seq'::regclass);


--
-- Name: denuncia cod_denuncia; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.denuncia ALTER COLUMN cod_denuncia SET DEFAULT nextval('public.denuncia_cod_denuncia_seq'::regclass);


--
-- Name: deuda_hidrologica id_deuda; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.deuda_hidrologica ALTER COLUMN id_deuda SET DEFAULT nextval('public.deuda_hidrologica_id_deuda_seq'::regclass);


--
-- Name: em_ejecutado id_ejecutado; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_ejecutado ALTER COLUMN id_ejecutado SET DEFAULT nextval('public.em_ejecutado_id_ejecutado_seq'::regclass);


--
-- Name: em_informe_semanal id_informe; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_informe_semanal ALTER COLUMN id_informe SET DEFAULT nextval('public."em_Informe_semanal_id_informe_seq"'::regclass);


--
-- Name: em_planificacion id_planificacion; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_planificacion ALTER COLUMN id_planificacion SET DEFAULT nextval('public.em_planificacion_id_planificacion_seq'::regclass);


--
-- Name: ente_publico id_ente; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ente_publico ALTER COLUMN id_ente SET DEFAULT nextval('public.ente_publico_id_ente_seq'::regclass);


--
-- Name: estado_mayor id_estado_mayor; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estado_mayor ALTER COLUMN id_estado_mayor SET DEFAULT nextval('public.estado_mayor_id_estado_mayor_seq'::regclass);


--
-- Name: estados_tramites cod_estado_tramite; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estados_tramites ALTER COLUMN cod_estado_tramite SET DEFAULT nextval('public.estados_tramite_cod_estado_seq'::regclass);


--
-- Name: ordenes id_orden; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ordenes ALTER COLUMN id_orden SET DEFAULT nextval('public.ordenes_id_orden_seq'::regclass);


--
-- Name: partido_politico id_partido; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.partido_politico ALTER COLUMN id_partido SET DEFAULT nextval('public.partido_politico_id_partido_seq'::regclass);


--
-- Name: peajes id_peaje; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.peajes ALTER COLUMN id_peaje SET DEFAULT nextval('public.peajes_id_peaje_seq'::regclass);


--
-- Name: profesion id_profesion; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.profesion ALTER COLUMN id_profesion SET DEFAULT nextval('public.profesion_id_profesion_seq'::regclass);


--
-- Name: punto_cuenta id_punto; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.punto_cuenta ALTER COLUMN id_punto SET DEFAULT nextval('public.punto_cuenta_id_punto_seq'::regclass);


--
-- Name: solicitantes id; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.solicitantes ALTER COLUMN id SET DEFAULT nextval('public.solicitantes_id_seq'::regclass);


--
-- Name: ticket cod_ticket; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ticket ALTER COLUMN cod_ticket SET DEFAULT nextval('public.ticket_cod_ticket_seq'::regclass);


--
-- Name: tipo_solicitantes cod_tipo_solicitante; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tipo_solicitantes ALTER COLUMN cod_tipo_solicitante SET DEFAULT nextval('public.tipo_solicitante_cod_tipo_solicitante_seq'::regclass);


--
-- Name: tramites cod_tramite; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tramites ALTER COLUMN cod_tramite SET DEFAULT nextval('public.tramite_cod_tramite_seq'::regclass);


--
-- Name: unidades cod_unidad; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.unidades ALTER COLUMN cod_unidad SET DEFAULT nextval('public.unidades_cod_unidad_seq'::regclass);


--
-- Name: comunidades comunidades_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.comunidades
    ADD CONSTRAINT comunidades_pkey PRIMARY KEY (idcom);


--
-- Name: denuncia denuncia_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.denuncia
    ADD CONSTRAINT denuncia_pkey PRIMARY KEY (cod_denuncia);


--
-- Name: detalles_ticket detalles_ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.detalles_ticket
    ADD CONSTRAINT detalles_ticket_pkey PRIMARY KEY (cod_detalle_ticket);


--
-- Name: deuda_hidrologica deuda_hidrologica_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.deuda_hidrologica
    ADD CONSTRAINT deuda_hidrologica_pkey PRIMARY KEY (id_deuda);


--
-- Name: em_informe_semanal em_Informe_semanal_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_informe_semanal
    ADD CONSTRAINT "em_Informe_semanal_pkey" PRIMARY KEY (id_informe);


--
-- Name: em_ejecutado em_ejecutado_id_planificacion_key; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_ejecutado
    ADD CONSTRAINT em_ejecutado_id_planificacion_key UNIQUE (id_planificacion);


--
-- Name: em_ejecutado em_ejecutado_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_ejecutado
    ADD CONSTRAINT em_ejecutado_pkey PRIMARY KEY (id_ejecutado);


--
-- Name: em_planificacion em_planificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_planificacion
    ADD CONSTRAINT em_planificacion_pkey PRIMARY KEY (id_planificacion);


--
-- Name: empresa empresa_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.empresa
    ADD CONSTRAINT empresa_pkey PRIMARY KEY (rif_empresa);


--
-- Name: ente_publico ente_publico_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ente_publico
    ADD CONSTRAINT ente_publico_pkey PRIMARY KEY (id_ente);


--
-- Name: estado_mayor estado_mayor_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estado_mayor
    ADD CONSTRAINT estado_mayor_pkey PRIMARY KEY (id_estado_mayor);


--
-- Name: estados estados_idest; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estados
    ADD CONSTRAINT estados_idest PRIMARY KEY (idest);


--
-- Name: municipios municipios_idmun; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.municipios
    ADD CONSTRAINT municipios_idmun PRIMARY KEY (idmun);


--
-- Name: niveles_acceso niveles_acceso_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.niveles_acceso
    ADD CONSTRAINT niveles_acceso_pkey PRIMARY KEY (codigo_nivel);


--
-- Name: ordenes ordenes_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ordenes
    ADD CONSTRAINT ordenes_pkey PRIMARY KEY (id_orden);


--
-- Name: parroquias parroquias_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.parroquias
    ADD CONSTRAINT parroquias_pkey PRIMARY KEY (codest, codmun, codpar);


--
-- Name: partido_politico partido_politico_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.partido_politico
    ADD CONSTRAINT partido_politico_pkey PRIMARY KEY (id_partido);


--
-- Name: peajes peajes_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.peajes
    ADD CONSTRAINT peajes_pkey PRIMARY KEY (id_peaje);


--
-- Name: permisos permisos_cedula_usuario_key; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_cedula_usuario_key UNIQUE (cedula_usuario);


--
-- Name: categorias pk_categoria; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT pk_categoria PRIMARY KEY (cod_categoria);


--
-- Name: estados_tramites pk_estados_tramite; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estados_tramites
    ADD CONSTRAINT pk_estados_tramite PRIMARY KEY (cod_estado_tramite);


--
-- Name: solicitantes pk_solicitante; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.solicitantes
    ADD CONSTRAINT pk_solicitante PRIMARY KEY (cedula_rif);


--
-- Name: tipo_solicitantes pk_tipo_solicitante; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tipo_solicitantes
    ADD CONSTRAINT pk_tipo_solicitante PRIMARY KEY (cod_tipo_solicitante);


--
-- Name: tramites pk_tramite; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tramites
    ADD CONSTRAINT pk_tramite PRIMARY KEY (cod_tramite);


--
-- Name: unidades pk_unidades; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.unidades
    ADD CONSTRAINT pk_unidades PRIMARY KEY (cod_unidad);


--
-- Name: profesion profesion_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.profesion
    ADD CONSTRAINT profesion_pkey PRIMARY KEY (id_profesion);


--
-- Name: ticket ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (cod_ticket, siglas);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (cedula_usuario);


--
-- Name: estados_codest; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX estados_codest ON public.estados USING btree (codest);


--
-- Name: municipios_codest; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX municipios_codest ON public.municipios USING btree (codest);


--
-- Name: municipios_codmun; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX municipios_codmun ON public.municipios USING btree (codmun);


--
-- Name: parroquias_codest; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX parroquias_codest ON public.parroquias USING btree (codest);


--
-- Name: parroquias_codmun; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX parroquias_codmun ON public.parroquias USING btree (codmun);


--
-- Name: parroquias_codpar; Type: INDEX; Schema: public; Owner: dimas
--

CREATE INDEX parroquias_codpar ON public.parroquias USING btree (codpar);


--
-- Name: detalles_ticket detalles_ticket_cod_estado_tramite_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.detalles_ticket
    ADD CONSTRAINT detalles_ticket_cod_estado_tramite_fkey FOREIGN KEY (cod_estado_tramite) REFERENCES public.estados_tramites(cod_estado_tramite) ON UPDATE CASCADE;


--
-- Name: detalles_ticket detalles_ticket_cod_ticket_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.detalles_ticket
    ADD CONSTRAINT detalles_ticket_cod_ticket_fkey FOREIGN KEY (cod_ticket, sigla) REFERENCES public.ticket(cod_ticket, siglas);


--
-- Name: detalles_ticket detalles_ticket_cod_unidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.detalles_ticket
    ADD CONSTRAINT detalles_ticket_cod_unidad_fkey FOREIGN KEY (cod_unidad) REFERENCES public.unidades(cod_unidad) ON UPDATE CASCADE;


--
-- Name: em_informe_semanal em_Informe_semanal_id_estado_mayor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_informe_semanal
    ADD CONSTRAINT "em_Informe_semanal_id_estado_mayor_fkey" FOREIGN KEY (id_estado_mayor) REFERENCES public.estado_mayor(id_estado_mayor);


--
-- Name: em_ejecutado em_ejecutado_id_planificado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_ejecutado
    ADD CONSTRAINT em_ejecutado_id_planificado_fkey FOREIGN KEY (id_planificacion) REFERENCES public.em_planificacion(id_planificacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: em_planificacion em_planificacion_id_estado_mayor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.em_planificacion
    ADD CONSTRAINT em_planificacion_id_estado_mayor_fkey FOREIGN KEY (id_estado_mayor) REFERENCES public.estado_mayor(id_estado_mayor) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: estado_mayor estado_mayor_cedula_res_nacional_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estado_mayor
    ADD CONSTRAINT estado_mayor_cedula_res_nacional_fkey FOREIGN KEY (cedula_res_nacional) REFERENCES public.usuarios(cedula_usuario) ON UPDATE CASCADE;


--
-- Name: estado_mayor estado_mayor_cedula_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.estado_mayor
    ADD CONSTRAINT estado_mayor_cedula_usuario_fkey FOREIGN KEY (cedula_res_regional) REFERENCES public.usuarios(cedula_usuario) ON UPDATE CASCADE;


--
-- Name: solicitantes fk_solicita_reference_tipo_sol; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.solicitantes
    ADD CONSTRAINT fk_solicita_reference_tipo_sol FOREIGN KEY (cod_tipo_solicitante) REFERENCES public.tipo_solicitantes(cod_tipo_solicitante) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: tramites fk_tramite_reference_categori; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tramites
    ADD CONSTRAINT fk_tramite_reference_categori FOREIGN KEY (cod_categoria) REFERENCES public.categorias(cod_categoria) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ordenes ordenes_cedula_usuario_orden_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ordenes
    ADD CONSTRAINT ordenes_cedula_usuario_orden_fkey FOREIGN KEY (cedula_usuario_orden) REFERENCES public.usuarios(cedula_usuario) ON UPDATE CASCADE;


--
-- Name: permisos permisos_cedula_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_cedula_usuario_fkey FOREIGN KEY (cedula_usuario) REFERENCES public.usuarios(cedula_usuario) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: punto_cuenta punto_cuenta_cedula_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.punto_cuenta
    ADD CONSTRAINT punto_cuenta_cedula_usuario_fkey FOREIGN KEY (cedula_usuario) REFERENCES public.usuarios(cedula_usuario);


--
-- Name: solicitantes solicitantes_idcom_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.solicitantes
    ADD CONSTRAINT solicitantes_idcom_fkey FOREIGN KEY (idcom) REFERENCES public.comunidades(idcom) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ticket ticket_cedula_rif_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_cedula_rif_fkey FOREIGN KEY (cedula_rif) REFERENCES public.solicitantes(cedula_rif) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: ticket ticket_cod_estado_tramite_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_cod_estado_tramite_fkey FOREIGN KEY (cod_estado_tramite) REFERENCES public.estados_tramites(cod_estado_tramite) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ticket ticket_cod_tramite_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_cod_tramite_fkey FOREIGN KEY (cod_tramite) REFERENCES public.tramites(cod_tramite) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: tramites tramites_cod_tipo_solicitante_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tramites
    ADD CONSTRAINT tramites_cod_tipo_solicitante_fkey FOREIGN KEY (cod_tipo_solicitante) REFERENCES public.tipo_solicitantes(cod_tipo_solicitante) ON UPDATE CASCADE;


--
-- Name: tramites tramites_cod_unidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.tramites
    ADD CONSTRAINT tramites_cod_unidad_fkey FOREIGN KEY (cod_unidad) REFERENCES public.unidades(cod_unidad) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: usuarios usuarios_cod_unidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_cod_unidad_fkey FOREIGN KEY (cod_unidad) REFERENCES public.unidades(cod_unidad) ON UPDATE CASCADE;


--
-- Name: usuarios usuarios_id_estado_mayor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_id_estado_mayor_fkey FOREIGN KEY (id_estado_mayor) REFERENCES public.estado_mayor(id_estado_mayor) ON UPDATE CASCADE;


--
-- PostgreSQL database dump complete
--

