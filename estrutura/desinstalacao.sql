drop table plugins.slipdepartamento;
drop sequence plugins.slipdepartamento_sequencial_seq;

--Menus
delete from configuracoes.db_menu   
      using configuracoes.db_itensmenu 
      where db_itensmenu.id_item = db_menu.id_item_filho 
        and db_itensmenu.desctec = 'Plugin: SlipDepartamento';

delete from configuracoes.db_permissao 
      using configuracoes.db_itensmenu 
      where db_itensmenu.id_item = db_permissao.id_item 
        and db_itensmenu.desctec = 'Plugin: SlipDepartamento';

delete from configuracoes.db_itensmenu 
      where db_itensmenu.desctec = 'Plugin: SlipDepartamento';
