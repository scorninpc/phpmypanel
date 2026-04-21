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