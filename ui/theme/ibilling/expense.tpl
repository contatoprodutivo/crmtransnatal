
{extends file="$tpl_admin_layout"}

{block name="content"}
    <div class="row">
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{$_L['Add Expense']}</h5>

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
                                    <option value="">{$_L['Choose an Account']}</option>
                                    {foreach $d as $ds}
                                        <option value="{$ds['account']}">{$ds['account']}</option>
                                    {/foreach}


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">{$_L['Date']}</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" value="{$mdate|date_format:"Y-m-d"}" name="date" id="date">

                              
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">{$_L['Description']}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" name="description">
                                <div class="help-block"><a data-toggle="modal" href="#modal_add_item"><i class="fa fa-paperclip"></i> {$_L['Attach File']}</a> </div>
                            </div>
                        </div>

                    

                        <div class="form-group">
    <label for="amount" class="col-sm-3 control-label">{$_L['Amount']}</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="amount" name="amount" placeholder="Valor da saída">
        </div>
    </div>
</div>
<div class="form-group">
                                <label for="cats" class="col-sm-3 control-label">{$_L['Category']}</label>
                                <div class="col-sm-9">
                                    <select id="cats" name="cats" class="form-control">
                                        <option value="Uncategorized">{$_L['Uncategorized']}</option>
                                        {foreach $cats as $cat}
                                            <option value="{$cat['name']}">{$cat['name']}</option>
                                        {/foreach}


                                    </select>
                                </div>
                            </div>




                            <div class="form-group">
                                <label for="tags" class="col-sm-3 control-label">{$_L['Tags']}</label>
                                <div class="col-sm-9">
                                    <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                        {foreach $tags as $tag}
                                            <option value="{$tag['text']}">{$tag['text']}</option>
                                        {/foreach}

                                    </select>
                                </div>
                            </div>


                             <div class="form-group">
                                <label for="ref" class="col-sm-3 control-label">{$_L['Ref']}#</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ref" name="ref">
                                    <span class="help-block">{$_L['ref_example']}</span>
                                </div>
                            </div>



                    
                           <div class="form-group">
                            <div class="col-sm-3">
                                &nbsp;
                            </div>
                            <div class="col-sm-9">
                                <h4><a href="#" id="a_toggle">{$_L['Advanced']}</a> </h4>
                            </div>
                        </div>
                        <div id="a_hide">
                            
                            <div class="form-group">
    <label for="nome_do_motorista" class="col-sm-3 control-label">Nome do Motorista</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="nome_do_motorista" name="nome_do_motorista" placeholder="Nome do Motorista">
    </div>
</div>

                            
       

<div class="form-group">
    <label for="data_saida" class="col-sm-3 control-label">Data de Saída</label>
    <div class="col-sm-9">
        <input type="date" class="form-control" id="data_saida" name="data_saida">
    </div>
</div>


<div class="form-group">
    <label for="data_chegada" class="col-sm-3 control-label">Data de Chegada</label>
    <div class="col-sm-9">
        <input type="date" class="form-control" id="data_chegada" name="data_chegada">
    </div>
</div>

<div class="form-group">
    <label for="valor_litro" class="col-sm-3 control-label">Valor por Litro</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="valor_litro" name="valor_litro" placeholder="Valor por Litro">
        </div>
    </div>
</div>
   <div class="form-group">
    <label for="qtd_litro" class="col-sm-3 control-label">Qtd. Litros</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="qtd_litro" name="qtd_litro" placeholder="Digite a quantidade em litros">
    </div>
</div>
<div class="form-group">
    <label for="valor_total" class="col-sm-3 control-label">Valor Total</label>
    <div class="col-sm-9">
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <input type="text" class="form-control" id="valor_total" name="valor_total" placeholder="Valor Total">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="km" class="col-sm-3 control-label">Km</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="km" name="km" placeholder="Quilometragem">
    </div>
</div>






                            
                     
                           
                            
                           
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="hidden" name="attachments" id="attachments" value="">
                                <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-check"></i> {$_L['Submit']}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{$_L['Recent Expense']}</h5>

                </div>
                <div class="ibox-content">

                    <table class="table table-bordered sys_table">
                        <thead>
                        <tr>
                            <th>{$_L['Description']}</th>
                            <th>{$_L['Amount']}</th>

                        </tr>
                        </thead>
                        <tbody>

                        {foreach $tr as $trs}
                            <tr>
                                <td><a href="{$_url}transactions/manage/{$trs['id']}">
                                        {if $trs['attachments'] neq ''}
                                            <i class="fa fa-paperclip"></i>
                                        {/if}
                                        {$trs['description']}
                                    </a> </td>
                                <td class="amount">{$trs['amount']}</td>
                            </tr>
                        {/foreach}

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="_lan_no_results_found" value="{$_L['No results found']}">

    <div id="modal_add_item" class="modal fade-scale" tabindex="-1" data-width="600" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">{$_L['Attach File']}</h4>
        </div>
        <div class="modal-body">
            <div class="row">



                <div class="col-md-12">
                    <form action="" class="dropzone" id="upload_container">

                        <div class="dz-message">
                            <h3> <i class="fa fa-cloud-upload"></i>  {$_L['Drop File Here']}</h3>
                            <br />
                            <span class="note">{$_L['Click to Upload']}</span>
                        </div>

                    </form>


                </div>




            </div>
        </div>
        <div class="modal-footer">

            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>

        </div>
    </div>
{/block}
