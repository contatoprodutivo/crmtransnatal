{extends file="$tpl_admin_layout"}

{block name="content"}
    <div class="row">
        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{$_L['Edit Transaction']} - [#{ib_lan_get_line($t['type'])}-{$t['id']}]</h5>

                </div>
                <div class="ibox-content" id="ibox_form">
                    <div class="alert alert-danger" id="emsg">
                        <span id="emsgbody"></span>
                    </div>
                    <form class="form-horizontal" method="post" id="tform" role="form">
                        <div class="form-group">
                            <label for="account" class="col-sm-3 control-label">{$_L['Account']}</label>
                            <div class="col-sm-9">
                                <select id="account" name="account" class="form-control">
                                    {foreach $d as $ds}
                                        <option value="{$ds['account']}" {if $ds['account'] eq $t['account']}selected="selected" {/if}>{$ds['account']}</option>
                                    {/foreach}


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">{$_L['Date']}</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control"  value="{$t['date']}" name="date" id="date" data-auto-close="true">
                               

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">{$_L['Description']}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" name="description" value="{$t['description']}">
                            </div>
                        </div>

              
                                                <div class="form-group">
    <label for="amount" class="col-sm-3 control-label">{$_L['Amount']}</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="amount" name="amount" value="{$t['amount']}">
        </div>
    </div>
</div>

                        {if $t['type'] neq 'Transfer'}
                            <div class="form-group">
                                <label for="cats" class="col-sm-3 control-label">{$_L['Category']}</label>
                                <div class="col-sm-9">
                                    <select id="cats" name="cats" class="form-control">
                                        <option value="Uncategorized">{$_L['Uncategorized']}</option>
                                        {foreach $cats as $cat}
                                            <option value="{$cat['name']}" {if $cat['name'] eq $t['category']}selected="selected" {/if}>{$cat['name']}</option>
                                        {/foreach}


                                    </select>
                                </div>
                            </div>
                        {else}
                            <input type="hidden" name="cats" id="cats" value="">
                        {/if}



                        <div class="form-group">
                            <label for="tags" class="col-sm-3 control-label">{$_L['Tags']}</label>
                            <div class="col-sm-9">
                                <select name="tags[]" id="tags"  class="form-control" multiple="multiple">
                                    {foreach $tags as $tag}
                                        <option value="{$tag['text']}" {if in_array($tag['text'],$dtags)}selected="selected"{/if}>{$tag['text']}</option>
                                    {/foreach}

                                </select>
                            </div>
                        </div>

      <div class="form-group">
                                <label for="ref" class="col-sm-3 control-label">{$_L['Ref']}#</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ref" name="ref" value="{$t['ref']}">
                                    <span class="help-block">{$_L['ref_example']}</span>
                                </div>
                            </div>

<div class="form-group">
    <label for="obs" class="col-sm-3 control-label">Observações</label>
    <div class="col-sm-9">
        <textarea class="form-control" id="obs" name="obs" rows="4" onkeydown="handleEnter(event, this.form)">{$t['obs']}</textarea>
    </div>
</div>

<script>
function handleEnter(event, form) {
    if (event.keyCode === 13 && !event.shiftKey) {  // Verifica se a tecla Enter foi pressionada sem a tecla Shift
        event.preventDefault();  // Evita o comportamento padrão de inserir nova linha
        form.submit();  // Envia o formulário
    }
}
</script>


                        
                        <div id="a_hide">
                            {if $t['type'] eq 'Income'}
                             
                            {else}
                               
                            {/if}                        
                        </div>


       
                            <div class="form-group">
    <label for="nome_do_motorista" class="col-sm-3 control-label">Nome do Motorista</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="nome_do_motorista" name="nome_do_motorista"  value="{$t['nome_do_motorista']}">
    </div>
</div>

<div class="form-group">
    <label for="diaria_motorista" class="col-sm-3 control-label">Diária motorista</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="diaria_motorista" name="diaria_motorista" value="{$t['diaria_motorista']}">
        </div>
    </div>
</div>


         <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Data de Saída</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control"  value="{$t['data_saida']}" name="data_saida" id="data_saida" data-auto-close="true">
                               

                            </div>
                        </div>                    
       

         <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Data de Chegada</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control"  value="{$t['data_chegada']}" name="data_chegada" id="data_chegada" data-auto-close="true">
                               

                            </div>
                        </div>  




<div class="form-group">
    <label for="valor_litro" class="col-sm-3 control-label">Valor por Litro</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="valor_litro" name="valor_litro" value="{$t['valor_litro']}">
        </div>
    </div>
</div>
   <div class="form-group">
    <label for="qtd_litro" class="col-sm-3 control-label">Qtd. Litros</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="qtd_litro" name="qtd_litro" value="{$t['qtd_litro']}">
    </div>
</div>
<div class="form-group">
    <label for="valor_total" class="col-sm-3 control-label">Valor Total</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="valor_total" name="valor_total" value="{$t['valor_total']}">
        </div>
    </div>
</div>

<!--Desativado -->
<!--
<div class="form-group">
    <label for="km" class="col-sm-3 control-label">Km</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="km" name="km" value="{$t['km']}">
    </div>
</div> -->



<div class="form-group">
    <label for="km_saida" class="col-sm-3 control-label">Km saída</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="km_saida" name="km_saida" value="{$t['km_saida']}">
    </div>
</div>

<div class="form-group">
    <label for="km_chegada" class="col-sm-3 control-label">Km chegada</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="km_chegada" name="km_chegada" value="{$t['km_chegada']}">
    </div>
</div>

<div class="form-group">
    <label for="pedagio" class="col-sm-3 control-label">Pedágio</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="pedagio" name="pedagio" value="{$t['pedagio']}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="outras_despesas" class="col-sm-3 control-label">Outras despesas</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="outras_despesas" name="outras_despesas" value="{$t['outras_despesas']}">
        </div>
    </div>
</div>      



  



                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="hidden" name="trid" id="trid" value="{$t['id']}">
                                <input type="hidden" id="trtype" name="trtype" value="{$t['type']}">
                                <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-check"></i> {$_L['Submit']}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-8">



            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{$_L['Delete']}</h5>

                </div>
                <div class="ibox-content">

                    <p>{$_L['tr_delete_warning']}</p>
                    <form role="form" method="post" action="{$_url}transactions/delete-post/">





                        <input type="hidden" name="id" value="{$t['id']}">

                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {$_L['Delete']}</button>
                    </form>

                </div>
            </div>

            {if $t['attachments'] neq ''}
                <div class="ibox float-e-margins">

                    <div class="ibox-content">

                        {IBilling_Viewer::transaction_attachment($t['attachments'])}

                    </div>
                </div>
            {/if}

        </div>

    </div>

    <input type="hidden" id="_lan_no_results_found" value="{$_L['No results found']}">
{/block}
