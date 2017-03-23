create table plugins.slipdepartamento (sequencial integer, 
                                       slip integer,  
                                       departamento integer);

create sequence plugins.slipdepartamento_sequencial_seq;

--Menus
--insert into configuracoes.db_itensmenu (id_item   ,
--                          descricao ,
--                          help      ,
--                          funcao    ,
--                          itemativo ,
--                          manutencao,
--                          desctec   ,
--                          libcliente)
--                  values (nextval('configuracoes.db_itensmenu_id_item_seq'), 
--                          'Alteração de departamento do Slip', 
--                          'Alteração de departamento do Slip - plugin', 
--                          'cai4_manutencaoslipdepartamento001.php', 
--                          1, 
--                          1, 
--                          'Plugin: SlipDepartamento', 
--                          true);

--insert into configuracoes.db_menu ( id_item, 
--                      id_item_filho, 
--                      menusequencia, 
--                      modulo ) 
--             values (96, 
--                     currval('configuracoes.db_itensmenu_id_item_seq'), 
--                     5, 
--                     39);

