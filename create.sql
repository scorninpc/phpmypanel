-- funcionalidades
CREATE TABLE funcionalidades (
	idfuncionalidade integer not null primary key AUTOINCREMENT, 
	nome varchar(250),
	controlador varchar(250),
	icone varchar(50)
);

INSERT INTO funcionalidades (nome, controlador) VALUES ('Usuarios', 'usuarios', 'fa-solid fa-user-group');
INSERT INTO funcionalidades (nome, controlador) VALUES ('Funcionalidades', 'funcionalidades', 'fa-solid fa-gears');

-- usuarios
CREATE TABLE usuarios (
	idusuario integer not null primary key AUTOINCREMENT, 
	nome varchar(100),
	email varchar(250), 
	password varchar(250)
);

INSERT INTO usuarios (email, password) VALUES ('Admin', 'test@localhost', '$2a$07$ZHyBfzO7xkSfuU5D3EIHGOmdI6DX2rSLu/.TPWCdAzu5Xugaqhby.'); -- senha 123mudar


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