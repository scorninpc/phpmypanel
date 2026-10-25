-- funcionalidades
CREATE TABLE funcionalidades (
	idfuncionalidade integer not null primary key AUTOINCREMENT, 
	nome varchar(250),
	controlador varchar(250),
	icone varchar(50),
	hide boolean not null default false,
	is_admin BOOLEAN,
	is_gerente BOOLEAN
);

INSERT INTO funcionalidades (nome, controlador, icone, hide, is_admin, is_gerente) VALUES ('Usuarios', 'usuarios', 'group', True, True, False);
INSERT INTO funcionalidades (nome, controlador, icone, hide, is_admin, is_gerente) VALUES ('Funcionalidades', 'funcionalidades', 'menu_book', True, True, False);
INSERT INTO funcionalidades (nome, controlador, icone, hide, is_admin, is_gerente) VALUES ('Parametrizações', 'parametrizacoes', 'tune', True, True, False);

-- usuarios
CREATE TABLE usuarios (
	idusuario integer not null primary key AUTOINCREMENT, 
	nome varchar(100),
	email varchar(250), 
	password varchar(250),
	is_admin BOOLEAN,
	is_gerente BOOLEAN
);

INSERT INTO usuarios (nome, email, password, is_admin, is_gerente) VALUES ('Admin', 'test@localhost', '$2a$07$ZHyBfzO7xkSfuU5D3EIHGOmdI6DX2rSLu/.TPWCdAzu5Xugaqhby.', True, True); -- senha 123mudar


-- tabela de testes
CREATE TABLE testes (
	idteste integer not null primary key AUTOINCREMENT, 
	campo_varchar varchar(250),
	campo_integer integer,
	campo_decimal decimal,
	campo_boolean boolean,
	campo_senha varchar(255),
	campo_texto text,
	campo_data date,
	campo_datahora datetime,
	campo_arquivo varchar(50)
);

-- tabela de parametrizações
CREATE TABLE parametrizacoes (
	idparametrizacao integer not null primary key AUTOINCREMENT,
	descricao VARCHAR(250) NOT NULL,
	chave VARCHAR(250) NOT NULL,
	valor TEXT NOT NULL,
	tipo VARCHAR(100)
);