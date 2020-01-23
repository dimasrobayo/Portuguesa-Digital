--
-- PostgreSQL database dump
--

-- Dumped from database version 10.5 (Ubuntu 10.5-0ubuntu0.18.04)
-- Dumped by pg_dump version 10.5 (Ubuntu 10.5-0ubuntu0.18.04)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

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
-- Name: denuncia cod_denuncia; Type: DEFAULT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.denuncia ALTER COLUMN cod_denuncia SET DEFAULT nextval('public.denuncia_cod_denuncia_seq'::regclass);


--
-- Data for Name: denuncia; Type: TABLE DATA; Schema: public; Owner: dimas
--

COPY public.denuncia (cod_denuncia, denuncia) FROM stdin;
\.


--
-- Name: denuncia_cod_denuncia_seq; Type: SEQUENCE SET; Schema: public; Owner: dimas
--

SELECT pg_catalog.setval('public.denuncia_cod_denuncia_seq', 1, false);


--
-- Name: denuncia denuncia_pkey; Type: CONSTRAINT; Schema: public; Owner: dimas
--

ALTER TABLE ONLY public.denuncia
    ADD CONSTRAINT denuncia_pkey PRIMARY KEY (cod_denuncia);


--
-- PostgreSQL database dump complete
--

