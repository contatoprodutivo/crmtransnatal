<?php
/* Smarty version 3.1.39, created on 2024-04-08 21:42:06
  from 'C:\laragon\www\cpcob03\ui\theme\ibilling\list-invoices.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_66148edeea0af6_10101580',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44012016ae403d24adad9b5977e3e73164db37eb' => 
    array (
      0 => 'C:\\laragon\\www\\cpcob03\\ui\\theme\\ibilling\\list-invoices.tpl',
      1 => 1684433528,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66148edeea0af6_10101580 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_213036871366148edee7a326_34601248', "content");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['tpl_admin_layout']->value));
}
/* {block "content"} */
class Block_213036871366148edee7a326_34601248 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_213036871366148edee7a326_34601248',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <div class="row">
        <div class="col-md-12 m-t-md">
            <div class="alert alert-danger" id="nmsg">
              <h4>
  Valor das faturas: <strong style="font-size: larger;"><?php echo $_smarty_tpl->tpl_vars['total_sum']->value;?>
</strong><br>
    Total de faturas: <strong style="font-size: larger;"><?php echo $_smarty_tpl->tpl_vars['total_selected']->value;?>
</strong><br>
  </h4>
                <span id="filter_message"><?php echo $_smarty_tpl->tpl_vars['filter_message']->value;?>
</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 ib_profile_width">

            <div class="panel panel-default" id="nbox_panel">

                <div class="panel-body">
                    <?php if ($_smarty_tpl->tpl_vars['view_type']->value == 'filter') {?>
<!-- Nome do filtro -->
  <h2>Filtros</h2>
                   <form class="form-horizontal" method="post" action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/list/filter/">
    <div class="form-group">
        <div class="col-md-12">
            <label>Status</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="fa fa-filter"></span>
                </div>
                <select name="situacao" class="form-control">
                    <<option value="">-- Selecione --</option>
                    <option value="A - Aberto">Aberto</option>
                    <option value="P - Pago">Pago</option>
                    <option value="C - Cancelado">Cancelado</option>
                    <option value="N - Negociado">Negociado</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>CPF</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="fa fa-id-card"></span>
                </div>
                <input type="text" name="cpf" class="form-control" placeholder="CPF"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>Data inicial</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="date" name="start_date" class="form-control" placeholder="Data inicial"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>Data final</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
                <input type="date" name="end_date" class="form-control" placeholder="Data final"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>Status</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="fa fa-balance-scale"></span>
                </div>
                <select name="status" class="form-control">
                    <option value="">-- Selecione --</option>
                    <option value="Active">Ativo</option>
                    <option value="Inactive">Inativo</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Search'];?>
</button>
            <a class="btn btn-success" href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/export_csv/"><i class="fa fa-download"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Baixar'];?>
</a>
        </div>
    </div>
</form>

 <?php }?> 

                </div>

                <div class="panel-body list-group border-bottom m-t-n-lg">
                    <!-- Links para outras partes do seu sistema aqui -->

                </div>

                <div class="panel-body">
                    <!-- Mais filtros ou opções aqui -->
                    
                </div>

            </div>

        </div>

        <div class="col-md-9">

            <!-- START TABELA -->
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <!-- Nome da tabela aqui-->
                </div>

                <div class="ibox-content" id="nbox_form">
                    <div id="application_ajaxrender" style="min-height: 200px;">
                        <!-- aqui começa a tabela -->


                    <table class="table table-bordered table-hover sys_table footable" <?php if ($_smarty_tpl->tpl_vars['view_type']->value == 'filter') {?> data-filter="#foo_filter" data-page-size="50" <?php }?>>
                        <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Status</th>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Vencimento</th>                            
                            <th>Situação</th>   
                            <th>Boleto</th>                         
                            
                            <th class="text-center">Atividades</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['d']->value, 'ds');
$_smarty_tpl->tpl_vars['ds']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ds']->value) {
$_smarty_tpl->tpl_vars['ds']->do_else = false;
?>
                            <tr>
                                <td data-value="<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
/invoices/" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
</td>
                            <td data-value="<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
/invoices/" target="_blank"><?php if ($_smarty_tpl->tpl_vars['ds']->value['status'] == 'Active') {?>Ativo<?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['status'] == 'Inactive') {?>Inativo<?php } else {
echo $_smarty_tpl->tpl_vars['ds']->value['status'];
}?></td>
                                <td data-value="<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
/invoices/" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ds']->value['cpf_titular'];?>
</td>
                                <td data-value="<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
/invoices/" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ds']->value['account'];?>
</td>
                                <td class="amount" data-a-sign="<?php if ($_smarty_tpl->tpl_vars['ds']->value['currency_symbol'] == '') {?> <?php echo $_smarty_tpl->tpl_vars['_c']->value['currency_code'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['ds']->value['currency_symbol'];
}?> "><?php echo $_smarty_tpl->tpl_vars['ds']->value['valor'];?>
</td>
                                <td data-value="<?php echo strtotime($_smarty_tpl->tpl_vars['ds']->value['data_vencimento']);?>
"><?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['ds']->value['data_vencimento']));?>
</td>  
                                                         
                                <td>

                                    <?php if ($_smarty_tpl->tpl_vars['ds']->value['situacao'] == 'A - Aberto') {?>
                                        <span class="label label-danger"><?php echo ib_lan_get_line($_smarty_tpl->tpl_vars['ds']->value['situacao']);?>
</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['situacao'] == 'P - Pago') {?>
                                        <span class="label label-success"><?php echo ib_lan_get_line($_smarty_tpl->tpl_vars['ds']->value['situacao']);?>
</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['situacao'] == 'N - Negociado') {?>
                                        <span class="label label-info"><?php echo ib_lan_get_line($_smarty_tpl->tpl_vars['ds']->value['situacao']);?>
</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['situacao'] == 'C - Cancelado') {?>
                                        <span class="label"><?php echo ib_lan_get_line($_smarty_tpl->tpl_vars['ds']->value['situacao']);?>
</span>
                                    <?php } else { ?>
                                        <?php echo ib_lan_get_line($_smarty_tpl->tpl_vars['ds']->value['situacao']);?>

                                    <?php }?>
                                </td>

                               
                                     <td class="text-center">
                                    <?php if ($_smarty_tpl->tpl_vars['ds']->value['link_boleto'] != '') {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['ds']->value['link_boleto'];?>
" target="_blank">
                                            Boleto
                                        </a>
                                    <?php }?>
                                </td>
                                <td class="text-center">

                                    <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['cliente_id'];?>
/activity/" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Ver histórico" target="_blank"><i class="fa fa-file-text-o"></i></a>
                            
                                </td>
                         
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                        </tbody>

                        <?php if ($_smarty_tpl->tpl_vars['view_type']->value == 'filter') {?>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination">
                                    </ul>
                                </td>
                            </tr>
                            </tfoot>
                        <?php }?>

                    </table>
<?php echo $_smarty_tpl->tpl_vars['paginator']->value['contents'];?>

                    </div>

                </div>
            </div>
            <!-- END TABELA -->

        </div>

    </div>

<?php
}
}
/* {/block "content"} */
}
