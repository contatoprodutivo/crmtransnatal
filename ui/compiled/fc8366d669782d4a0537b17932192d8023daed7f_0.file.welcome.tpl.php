<?php
/* Smarty version 3.1.39, created on 2023-05-18 15:57:29
  from '/home/u271859541/domains/contatoprodutivo.com.br/public_html/cpcob03/ui/theme/ibilling/welcome.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_64667519b01437_87805569',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fc8366d669782d4a0537b17932192d8023daed7f' => 
    array (
      0 => '/home/u271859541/domains/contatoprodutivo.com.br/public_html/cpcob03/ui/theme/ibilling/welcome.tpl',
      1 => 1684433089,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64667519b01437_87805569 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_123413233264667519afe9e3_01915234', "content");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['tpl_admin_layout']->value));
}
/* {block "content"} */
class Block_123413233264667519afe9e3_01915234 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_123413233264667519afe9e3_01915234',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <div class="row">
        <div class="col-md-12">

            <?php echo $_smarty_tpl->tpl_vars['_L']->value['Welcome'];?>
!

        </div>



    </div>

<?php
}
}
/* {/block "content"} */
}
