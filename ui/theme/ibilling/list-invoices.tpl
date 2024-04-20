{extends file="$tpl_admin_layout"}

{block name="content"}

    <div class="row">
        <div class="col-md-12 m-t-md">
            <div class="alert alert-danger" id="nmsg">
              <h4>
  Valor das faturas: <strong style="font-size: larger;">{$total_sum}</strong><br>
    Total de faturas: <strong style="font-size: larger;">{$total_selected}</strong><br>
  </h4>
                <span id="filter_message">{$filter_message}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 ib_profile_width">

            <div class="panel panel-default" id="nbox_panel">

                <div class="panel-body">
                    {if $view_type == 'filter'}
<!-- Nome do filtro -->
  <h2>Filtros</h2>
                   <form class="form-horizontal" method="post" action="{$_url}invoices/list/filter/">
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
            <button type="submit" class="btn btn-primary">{$_L['Search']}</button>
            <a class="btn btn-success" href="{$_url}invoices/export_csv/"><i class="fa fa-download"></i> {$_L['Baixar']}</a>
        </div>
    </div>
</form>

 {/if} 

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


                    <table class="table table-bordered table-hover sys_table footable" {if $view_type == 'filter'} data-filter="#foo_filter" data-page-size="50" {/if}>
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

                        {foreach $d as $ds}
                            <tr>
                                <td data-value="{$ds['cliente_id']}"><a href="{$_url}contacts/view/{$ds['cliente_id']}/invoices/" target="_blank">{$ds['cliente_id']}</td>
                            <td data-value="{$ds['cliente_id']}"><a href="{$_url}contacts/view/{$ds['cliente_id']}/invoices/" target="_blank">{if $ds.status eq 'Active'}Ativo{elseif $ds.status eq 'Inactive'}Inativo{else}{$ds.status}{/if}</td>
                                <td data-value="{$ds['cliente_id']}"><a href="{$_url}contacts/view/{$ds['cliente_id']}/invoices/" target="_blank">{$ds['cpf_titular']}</td>
                                <td data-value="{$ds['cliente_id']}"><a href="{$_url}contacts/view/{$ds['cliente_id']}/invoices/" target="_blank">{$ds['account']}</td>
                                <td class="amount" data-a-sign="{if $ds['currency_symbol'] eq ''} {$_c['currency_code']} {else} {$ds['currency_symbol']}{/if} ">{$ds['valor']}</td>
                                <td data-value="{strtotime($ds['data_vencimento'])}">{date( $_c['df'], strtotime($ds['data_vencimento']))}</td>  
                                                         
                                <td>

                                    {if $ds['situacao'] eq 'A - Aberto'}
                                        <span class="label label-danger">{ib_lan_get_line($ds['situacao'])}</span>
                                    {elseif $ds['situacao'] eq 'P - Pago'}
                                        <span class="label label-success">{ib_lan_get_line($ds['situacao'])}</span>
                                    {elseif $ds['situacao'] eq 'N - Negociado'}
                                        <span class="label label-info">{ib_lan_get_line($ds['situacao'])}</span>
                                    {elseif $ds['situacao'] eq 'C - Cancelado'}
                                        <span class="label">{ib_lan_get_line($ds['situacao'])}</span>
                                    {else}
                                        {ib_lan_get_line($ds['situacao'])}
                                    {/if}
                                </td>

                               
                                     <td class="text-center">
                                    {if $ds['link_boleto'] != ''}
                                        <a href="{$ds['link_boleto']}" target="_blank">
                                            Boleto
                                        </a>
                                    {/if}
                                </td>
                                <td class="text-center">

                                    <a href="{$_url}contacts/view/{$ds['cliente_id']}/activity/" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Ver histórico" target="_blank"><i class="fa fa-file-text-o"></i></a>
                            
                                </td>
                         
                            </tr>
                        {/foreach}

                        </tbody>

                        {if $view_type == 'filter'}
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination">
                                    </ul>
                                </td>
                            </tr>
                            </tfoot>
                        {/if}

                    </table>
{$paginator['contents']}
                    </div>

                </div>
            </div>
            <!-- END TABELA -->

        </div>

    </div>

{/block}
