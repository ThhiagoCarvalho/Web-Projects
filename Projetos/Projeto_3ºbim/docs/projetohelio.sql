use mydb;
SELECT * FROM mydb.categoria;
SELECT * FROM mydb.opcoes;
SELECT count(*) AS qtd, nomeOpcao FROM opcoes WHERE nomeOpcao = 'restaurante sp'   GROUP BY nomeOpcao;
SELECT * FROM mydb.usuario;
delete from categoria where idCategoria = 18;
delete from opcoes where idOpcoes =68;
select * from  opcoes where idOpcoes =68;
SELECT count(*) AS qtd, idUsuario,nomeUsuario, emailUsuario,idade,dataDate,Categoria_idCategoria FROM usuario WHERE emailUsuario = 'cesar@gmail' AND senhaUsuario = md5(12345)  GROUP BY idUsuario, nomeUsuario, emailUsuario, idade,dataDate,Categoria_idCategoria;
SELECT opcoes.nomeOpcao, opcoes.descricao, opcoes.horarioFucionamento,opcoes.localizacaoOpcao,idOpcoes, custoEstimado FROM opcoes JOIN categoria ON categoria.idCategoria = opcoes.Categoria_idCategoria WHERE categoria.idCategoria = 1;
SELECT opcoes.nomeOpcao FROM opcoes
JOIN categoria ON categoria.idCategoria = opcoes.Categoria_idCategoria
WHERE categoria.idCategoria = 1;

SELECT count(*) AS qtd, emailUsuario FROM usuario WHERE emailUsuario = 'Nicolasss@gmail.comn'   GROUP BY emailusuario;

SELECT count(*) AS qtd, nomeOpcao FROM opcoes WHERE nomeOpcao = 'Palácio Gourmet'  GROUP BY nomeOpcao
insert into opcoes (nomeOpcao,localizacaoOpcao,horarioFucionamento,custoEstimado,Categoria_idCategoria,descricao) values 
('Restaurante thiaguin','sp','12h','R$1300',1,'Este restaurante e bastante conhecido pela cidade devido as suas comidas feitas por master-chefs');



insert into usuario (nomeUsuario,emailUsuario,senhaUsuario,idade,dataDate,Categoria_idCategoria) 
values ('thiago1','testeapenas@gmial.com',12345,17,11/03/21',1)
