{extends file="$tpl_admin_layout"}

{block name="content"}

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{$_L['Manage Tags']} </h5>
        </div>
        <div class="ibox-content">

            <table class="table table-bordered table-hover sys_table">
                <thead>
                <tr>

                    <th>{$_L['Tag']}</th>
                    <th>{$_L['Type']}</th>
                    <th>{$_L['Delete']}</th>

                </tr>
                </thead>
                <tbody>

                {foreach $d as $ds}
                    <tr>

                        <td>{$ds['text']}</td>
                         <td>
                                        {if $ds['type'] eq 'Income'}
                                            {$_L['Income']}
                                        {elseif $ds['type'] eq 'Expense'}
                                            {$_L['Expense']}
                                        {elseif $ds['type'] eq 'Transfer'}
                                            {$_L['Transfer']}
                                        {else}
                                            {$ds['type']}
                                        {/if}
                                    </td>
                        <td>
                            <a href="#" class="btn btn-danger btn-xs cdelete" id="iid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>
                        </td>
                    </tr>
                {/foreach}

                </tbody>
            </table>

        </div>
    </div>

{/block}