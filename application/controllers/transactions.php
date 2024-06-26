<?php
_auth();
$ui->assign('_title', $_L['Transactions'] . '- ' . $config['CompanyName']);
$ui->assign('_st', $_L['Transactions']);
$ui->assign('_application_menu', 'transactions');
$ui->assign('content_inner', inner_contents($config['c_cache']));
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
$mdate = date('Y-m-d');

//js var

$ui->assign(
    'jsvar',
    '
_L[\'Working\'] = \'' .
        $_L['Working'] .
        '\';
_L[\'Submit\'] = \'' .
        $_L['Submit'] .
        '\';
 '
);

Event::trigger('transactions');
//
switch ($action) {
    case 'deposit':
        Event::trigger('transactions/deposit/');

        $d = ORM::for_table('sys_accounts')->find_many();
        $p = ORM::for_table('crm_accounts')->find_many();
        $ui->assign('p', $p);
        $ui->assign('d', $d);
        $cats = ORM::for_table('sys_cats')
            ->where('type', 'Income')
            ->order_by_asc('sorder')
            ->find_many();
        $ui->assign('cats', $cats);
        $pms = ORM::for_table('sys_pmethods')->find_many();
        $ui->assign('pms', $pms);
        $ui->assign('mdate', $mdate);

        $tags = Tags::get_all('Income');
        $ui->assign('tags', $tags);

        $ui->assign(
            'xheader',
            Asset::css([
                'dropzone/dropzone',
                'modal',
                's2/css/select2.min',
                'dp/dist/datepicker.min',
            ])
        );

        $ui->assign(
            'xfooter',
            Asset::js([
                'modal',
                'dropzone/dropzone',
                's2/js/select2.min',
                's2/js/i18n/' . lan(),
                'dp/dist/datepicker.min',
                'dp/i18n/' . $config['language'],
                'numeric',
                'deposit',
            ])
        );

        $ui->assign(
            'xjq',
            '
 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

 '
        );
        //find latest income
        $tr = ORM::for_table('sys_transactions')
            ->where('type', 'Income')
            ->order_by_desc('id')
            ->limit('20')
            ->find_many();
        $ui->assign('tr', $tr);
        $ui->display('deposit.tpl');

        break;

    case 'deposit-post':
        Event::trigger('transactions/deposit-post/');

        $account = _post('account');
        $date = _post('date');
        $amount = _post('amount');
        /* @since v2. added support for ',' as decimal separator */
        $amount = Finance::amount_fix($amount);
        $payerid = _post('payer');
        $ref = _post('ref');
        $pmethod = _post('pmethod');
        $cat = _post('cats');
        $tags = $_POST['tags'];

        /* @since Build 4560. added support file attachments */

        $attachments = _post('attachments');

        if ($payerid == '') {
            $payerid = '0';
        }
        $description = _post('description');
        $msg = '';
        if ($description == '') {
            $msg .= $_L['description_error'] . '<br>';
        }

        if (Validator::Length($account, 100, 1) == false) {
            $msg .= $_L['Choose an Account'] . ' ' . '<br>';
        }

        if (is_numeric($amount) == false) {
            $msg .= $_L['amount_error'] . '<br>';
        }

        if ($msg == '') {
            Tags::save($tags, 'Income');

            //find the current balance for this account
            $a = ORM::for_table('sys_accounts')
                ->where('account', $account)
                ->find_one();
            $cbal = $a['balance'];
            $nbal = $cbal + $amount;
            $a->balance = $nbal;
            $a->save();
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $account;
            $d->type = 'Income';
            $d->payerid = $payerid;
            $d->tags = Arr::arr_to_str($tags);
            $d->amount = $amount;
            $d->category = $cat;
            $d->method = $pmethod;
            $d->ref = $ref;

            $d->description = $description;
            // Build 4560
            $d->attachments = $attachments;
            $d->date = $date;
            $d->dr = '0.00';
            $d->cr = $amount;
            $d->bal = $nbal;

            //others
            $d->payer = '';
            $d->payee = '';
            $d->payeeid = '0';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = 0;
            $d->aid = 0;
            $d->updated_at = date('Y-m-d H:i:s');
            //

            $d->save();
            $tid = $d->id();
            _log(
                'New Deposit: ' .
                    $description .
                    ' [TrID: ' .
                    $tid .
                    ' | Amount: ' .
                    $amount .
                    ']',
                'Admin',
                $user['id']
            );
            _msglog('s', $_L['Transaction Added Successfully']);
            echo $tid;
        } else {
            echo $msg;
        }
        break;

    case 'expense':
        Event::trigger('transactions/expense/');

        $d = ORM::for_table('sys_accounts')->find_many();
        $p = ORM::for_table('crm_accounts')->find_many();
        $ui->assign('p', $p);
        $ui->assign('d', $d);
        $tags = Tags::get_all('Expense');
        $ui->assign('tags', $tags);
        $cats = ORM::for_table('sys_cats')
            ->where('type', 'Expense')
            ->order_by_asc('sorder')
            ->find_many();
        $ui->assign('cats', $cats);
        $pms = ORM::for_table('sys_pmethods')->find_many();
        $ui->assign('pms', $pms);
        $ui->assign('mdate', $mdate);

        $ui->assign(
            'xheader',
            Asset::css([
                'dropzone/dropzone',
                'modal',
                's2/css/select2.min',
                'dp/dist/datepicker.min',
            ])
        );

        $ui->assign(
            'xfooter',
            Asset::js([
                'modal',
                'dropzone/dropzone',
                's2/js/select2.min',
                's2/js/i18n/' . lan(),
                'dp/dist/datepicker.min',
                'dp/i18n/' . $config['language'],
                'numeric',
                'expense',
            ])
        );

        $ui->assign(
            'xjq',
            '

 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

 '
        );
        //find latest income
        $tr = ORM::for_table('sys_transactions')
            ->where('type', 'Expense')
            ->order_by_desc('id')
            ->limit('20')
            ->find_many();
        $ui->assign('tr', $tr);

        $ui->display('expense.tpl');

        break;

    case 'expense-post':
        Event::trigger('transactions/expense-post/');

        $account = _post('account');
        $date = _post('date');
        $amount = _post('amount');
        $amount = Finance::amount_fix($amount);
        $payee = _post('payee');
        $ref = _post('ref');
        $pmethod = _post('pmethod');
        $cat = _post('cats');
        $tags = $_POST['tags'];
       

        //novos campos
        $qtd_litro = _post('qtd_litro');
        $qtd_litro = str_replace(',', '.', _post('qtd_litro'));
        $qtd_litro = floatval($qtd_litro);
        $nome_do_motorista = _post('nome_do_motorista');
        $data_saida = _post('data_saida'); 
        $data_chegada = _post('data_chegada');
        $valor_litro = _post('valor_litro');
        $valor_total = _post('valor_total');
        $km = isset($_POST['km']) ? $_POST['km'] : '0';
        $obs = _post('obs');

        $km_saida = _post('km_saida');
        $km_chegada = _post('km_chegada');
        $diaria_motorista = _post('diaria_motorista');
        $pedagio = _post('pedagio');
        $outras_despesas = _post('outras_despesas');



        // Converta os valores decimais adequadamente, se necessário
        $valor_litro = floatval(str_replace(',', '.', $valor_litro));
        $valor_total = floatval(str_replace(',', '.', $valor_total));
        $km = floatval(str_replace(',', '.', $km));
        



        $attachments = _post('attachments');

        error_log(print_r($_POST, true));


       // Verifica se a data de saída está vazia e valida o formato apenas se ela for fornecida
if (!empty($data_saida) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_saida)) {
    error_log("Data de Saída inválida: " . $data_saida);
    // Adicione o código para tratar o erro conforme necessário
} else if (empty($data_saida)) {
    $data_saida = null;  // Define como null para salvar no banco de dados, se o banco aceitar null
}

      // Verifica se a data de chegada está vazia e valida o formato apenas se ela for fornecida
      if (!empty($data_chegada) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_chegada)) {
        error_log("Data de Chegada inválida: " . $data_chegada);
        // Adicione o código para tratar o erro conforme necessário
    } else if (empty($data_chegada)) {
        $data_chegada = null;  // Define como null para salvar no banco de dados, se o banco aceitar null
    }
    

        if (!is_numeric($payee)) {
            $payee = '0';
        }
        if (!is_numeric($qtd_litro)) {
            $msg .= "Quantidade em litros inválida.<br>";
        }
        
       

        $description = _post('description');
        $msg = '';
        if ($description == '') {
            $msg .= $_L['description_error'] . '<br>';
        }

        if (Validator::Length($account, 100, 1) == false) {
            $msg .= $_L['Choose an Account'] . ' ' . '<br>';
        }

        if (is_numeric($amount) == false) {
            $msg .= $_L['amount_error'] . '<br>';
        }

        if ($msg == '') {
            Tags::save($tags, 'Expense');

            //find the current balance for this account
            $a = ORM::for_table('sys_accounts')
                ->where('account', $account)
                ->find_one();
            $cbal = $a['balance'];
            $nbal = $cbal - $amount;
            $a->balance = $nbal;
            $a->save();
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $account;            
            $d->type = 'Expense';
            $d->payeeid = $payee;
            $d->tags = Arr::arr_to_str($tags);
            $d->amount = $amount;
            $d->category = $cat;
            $d->method = $pmethod;
            $d->ref = $ref;

            // Adicionando novos campos
            $d->qtd_litro = $qtd_litro;
            $d->nome_do_motorista = $nome_do_motorista;
            $d->data_saida = $data_saida;
            $d->data_chegada = $data_chegada;
            $d->valor_litro = $valor_litro;
            $d->valor_total = $valor_total;
            $d->km = $km;
            $d->obs = $obs;

            $d->km_saida = $km_saida;
            $d->km_chegada = $km_chegada;
            $d->diaria_motorista = $diaria_motorista;
            $d->pedagio = $pedagio;
            $d->outras_despesas = $outras_despesas;

            $d->description = $description;
            // Build 4560
            $d->attachments = $attachments;
            $d->date = $date;
            $d->dr = $amount;
            $d->cr = '0.00';
            $d->bal = $nbal;
            //others
            $d->payer = '';
            $d->payee = '';
            $d->payerid = '0';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = 0;

            $d->aid = 0;
            $d->updated_at = date('Y-m-d H:i:s');

            $d->save();
            $tid = $d->id();
            _log(
                'New Expense: ' .
                    $description .
                    ' [TrID: ' .
                    $tid .
                    ' | Amount: ' .
                    $amount .
                    ']',
                'Admin',
                $user['id']
            );
            _msglog('s', $_L['Transaction Added Successfully']);
            echo $tid;
        } else {
            echo $msg;
        }
        break;

        case 'edit-post':
            Event::trigger('transactions/edit-post/');
        
            $id = _post('id');
            $d = ORM::for_table('sys_transactions')->find_one($id);
            if ($d) {
                // Atribuições diretas dos campos
                $cat = _post('cats');
                $account = _post('account');
                $pmethod = _post('pmethod');
                $ref = _post('ref');
                $date = _post('date');
                $payer = _post('payer', '0');  // Valor padrão se não definido
                $amount = _post('amount');
                $payee = _post('payee', '0');  // Valor padrão se não definido
                $description = _post('description');
                $tags = $_POST['tags'] ?? [];  // Assegurando que é um array, mesmo que vazio
        
                // Novos campos, com conversão de valores numéricos corrigida
                $qtd_litro = floatval(str_replace(',', '.', _post('qtd_litro')));
                $nome_do_motorista = _post('nome_do_motorista');
                $data_saida = _post('data_saida');
                $data_saida = empty($data_saida) ? null : $data_saida;  // Atribui null se estiver vazio
                $data_chegada = _post('data_chegada');
                $data_chegada = empty($data_chegada) ? null : $data_chegada;  // Atribui null se estiver vazio
                $valor_litro = floatval(str_replace(',', '.', _post('valor_litro')));
                $valor_total = floatval(str_replace(',', '.', _post('valor_total')));
                $km = floatval(str_replace(',', '.', _post('km', '0')));  // Padrão para 0 se não definido
                $obs = _post('obs');

                $km_saida = _post('km_saida');
                $km_chegada = _post('km_chegada');
                $diaria_motorista = _post('diaria_motorista');
                $pedagio = _post('pedagio');
                $outras_despesas = _post('outras_despesas');
        
                $msg = '';
        
                // Verificações de validação
                if (empty($description)) {
                    $msg .= $_L['description_error'] . '<br>';
                }
        
                // Processamento e salvamento
                if (empty($msg)) {
                    $d->category = $cat;
                    $d->account = $account;
                    $d->payerid = $payer;
                    $d->amount = $amount;
                    $d->payeeid = $payee;
                    $d->method = $pmethod;
                    $d->ref = $ref;
                    $d->description = $description;
                    $d->date = $date;
                    $d->qtd_litro = $qtd_litro;
                    $d->nome_do_motorista = $nome_do_motorista;
                    $d->data_saida = $data_saida;
                    $d->data_chegada = $data_chegada;
                    $d->valor_litro = $valor_litro;
                    $d->valor_total = $valor_total;
                    $d->km = $km;
                    $d->obs = $obs;

                    $d->km_saida = $km_saida;
                    $d->km_chegada = $km_chegada;
                    $d->diaria_motorista = $diaria_motorista;
                    $d->pedagio = $pedagio;
                    $d->outras_despesas = $outras_despesas;
        
                    Tags::save($tags, $d['type']);
                    $d->tags = Arr::arr_to_str($tags);
        
                    if ($d->save()) {
                        _msglog('s', $_L['edit_successful']);
                        echo $d->id();
                    } else {
                        echo 'Error saving transaction.';
                    }
                } else {
                    echo $msg;
                }
            } else {
                echo 'Transaction Not Found';
            }
        
            break;
        
        
    case 'delete-post':
        Event::trigger('transactions/delete-post/');

        if (!has_access($user->roleid, 'transactions', 'delete')) {
            permissionDenied();
        }

        $id = _post('id');
        if (Transaction::remove($id)) {
            r2(
                U . 'transactions/list',
                's',
                $_L['transaction_delete_successful']
            );
        } else {
            r2(U . 'transactions/list', 'e', $_L['an_error_occured']);
        }
        break;

    case 'transfer':
        Event::trigger('transactions/transfer/');

        $d = ORM::for_table('sys_accounts')->find_many();
        $ui->assign('p', $d);
        $ui->assign('d', $d);

        $pms = ORM::for_table('sys_pmethods')->find_many();
        $ui->assign('pms', $pms);
        $ui->assign('mdate', $mdate);
        $tags = Tags::get_all('Transfer');
        $ui->assign('tags', $tags);
        $ui->assign(
            'xheader',
            Asset::css(['s2/css/select2.min', 'dp/dist/datepicker.min'])
        );

        $ui->assign(
            'xfooter',
            Asset::js([
                's2/js/select2.min',
                's2/js/i18n/' . lan(),
                'dp/dist/datepicker.min',
                'dp/i18n/' . $config['language'],
                'numeric',
                'transfer',
            ])
        );

        $ui->assign(
            'xjq',
            '

 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

 '
        );
        //find latest income
        $tr = ORM::for_table('sys_transactions')
            ->where('type', 'Transfer')
            ->order_by_desc('id')
            ->limit('20')
            ->find_many();
        $ui->assign('tr', $tr);
        $ui->display('transfer.tpl');

        break;

    case 'transfer-post':
        Event::trigger('transactions/transfer-post/');

        $faccount = _post('faccount');
        $taccount = _post('taccount');
        $date = _post('date');
        $amount = _post('amount');
        $amount = Finance::amount_fix($amount);
        $pmethod = _post('pmethod');
        $ref = _post('ref');

        $description = _post('description');
        $msg = '';
        if (Validator::Length($faccount, 100, 2) == false) {
            $msg .= $_L['Choose an Account'] . ' ' . '<br>';
        }

        if (Validator::Length($taccount, 100, 2) == false) {
            $msg .= $_L['Choose the Traget Account'] . ' ' . '<br>';
        }

        if ($description == '') {
            $msg .= $_L['description_error'] . '<br>';
        }

        if (is_numeric($amount) == false) {
            $msg .= $_L['amount_error'] . '<br>';
        }

        //check if from account & target account is same

        if ($faccount == $taccount) {
            $msg .= $_L['same_account_error'] . '<br>';
        }

        $tags = $_POST['tags'];

        Tags::save($tags, 'Transfer');

        if ($msg == '') {
            $a = ORM::for_table('sys_accounts')
                ->where('account', $faccount)
                ->find_one();
            $cbal = $a['balance'];
            $nbal = $cbal - $amount;
            $a->balance = $nbal;
            $a->save();
            $a = ORM::for_table('sys_accounts')
                ->where('account', $taccount)
                ->find_one();
            $cbal = $a['balance'];
            $tnbal = $cbal + $amount;
            $a->balance = $tnbal;
            $a->save();
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $faccount;
            $d->type = 'Transfer';

            $d->amount = $amount;

            $d->method = $pmethod;
            $d->ref = $ref;
            $d->tags = Arr::arr_to_str($tags);

            $d->description = $description;
            $d->date = $date;
            $d->dr = $amount;
            $d->cr = '0.00';
            $d->bal = $nbal;

            //others
            $d->payer = '';
            $d->payee = '';
            $d->payerid = '0';
            $d->payeeid = '0';
            $d->category = '';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = 0;
            $d->aid = 0;
            $d->updated_at = date('Y-m-d H:i:s');
            //

            $d->save();
            //transaction for target account
            $d = ORM::for_table('sys_transactions')->create();
            $d->account = $taccount;
            $d->type = 'Transfer';

            $d->amount = $amount;

            $d->method = $pmethod;
            $d->ref = $ref;
            $d->tags = Arr::arr_to_str($tags);
            $d->description = $description;
            $d->date = $date;
            $d->dr = '0.00';
            $d->cr = $amount;
            $d->bal = $tnbal;

            //others
            $d->payer = '';
            $d->payee = '';
            $d->payerid = '0';
            $d->payeeid = '0';
            $d->category = '';
            $d->status = 'Cleared';
            $d->tax = '0.00';
            $d->iid = 0;
            $d->aid = 0;
            $d->updated_at = date('Y-m-d H:i:s');
            //

            $d->save();
            _msglog('s', $_L['Transaction Added Successfully']);
            echo '1';
        } else {
            echo $msg;
        }
        break;

    case 'list':
        Event::trigger('transactions/list/');

        $paginator = Paginator::bootstrap('sys_transactions');
        $d = ORM::for_table('sys_transactions')
            ->offset($paginator['startpoint'])
            ->limit($paginator['limit'])
            ->order_by_desc('date')
            ->find_many();
        $ui->assign('d', $d);
        $ui->assign('paginator', $paginator);

        $ui->assign(
            '_st',
            $_L['Transactions'] .
                '<div class="btn-group pull-right" style="padding-right: 10px;">
  <a class="btn btn-success btn-xs" href="' .
                U .
                'transactions/export_csv/' .
                '" style="box-shadow: none;"><i class="fa fa-download"></i></a>
</div>'
        );

        $ui->assign('xfooter', Asset::js(['numeric']));

        $ui->assign(
            'xjq',
            '

 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

 '
        );

        $ui->display('transactions.tpl');
        break;

    case 'a':
        Event::trigger('transactions/a/');

        $d = ORM::for_table('sys_accounts')->find_many();
        // $p = ORM::for_table('sys_payers')->find_many();
        $p = ORM::for_table('crm_accounts')->find_many();
        $ui->assign('p', $p);
        $ui->assign('d', $d);
        $cats = ORM::for_table('sys_cats')
            ->where('type', 'Income')
            ->order_by_asc('sorder')
            ->find_many();
        $ui->assign('cats', $cats);
        $pms = ORM::for_table('sys_pmethods')->find_many();
        $ui->assign('pms', $pms);
        $ui->assign(
            'xheader',
            Asset::css([
                's2/css/select2.min',
                'dp/dist/datepicker.min',
                'dt/media/css/jquery.dataTables.min',
                'modal',
                'css/dta',
            ])
        );

        $ui->assign(
            'xfooter',
            Asset::js([
                's2/js/select2.min',
                's2/js/i18n/' . lan(),
                'dp/dist/datepicker.min',
                'dp/i18n/' . $config['language'],
                'numeric',
                'modal',
                'dt/media/js/jquery.dataTables.min',
                'js/dta',
                'js/tra',
            ])
        );

        $ui->assign(
            'xjq',
            '


 '
        );

        $ui->display('tra.tpl');

        break;

    case 'list-income':
        Event::trigger('transactions/list-income/');

        $ui->assign('_application_menu', 'reports');
        $paginator = Paginator::bootstrap('sys_transactions', 'type', 'Income');
        $d = ORM::for_table('sys_transactions')
            ->where('type', 'Income')
            ->offset($paginator['startpoint'])
            ->limit($paginator['limit'])
            ->order_by_desc('date')
            ->find_many();
        $ui->assign('d', $d);

        $ui->assign('xfooter', Asset::js(['numeric']));
        $ui->assign(
            'xjq',
            '

         $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

        '
        );
        $ui->assign('paginator', $paginator);
        $ui->display('transactions.tpl');
        break;

    case 'list-expense':
        Event::trigger('transactions/list-expense/');

        $ui->assign('_application_menu', 'reports');
        $paginator = Paginator::bootstrap(
            'sys_transactions',
            'type',
            'Expense'
        );
        $d = ORM::for_table('sys_transactions')
            ->where('type', 'Expense')
            ->offset($paginator['startpoint'])
            ->limit($paginator['limit'])
            ->order_by_desc('date')
            ->find_many();
        $ui->assign('d', $d);

        $ui->assign(
            'xjq',
            '

         $(\'.amount\').autoNumeric(\'init\', {

    aSign: \'' .
                $config['currency_code'] .
                ' \',
    dGroup: ' .
                $config['thousand_separator_placement'] .
                ',
    aPad: ' .
                $config['currency_decimal_digits'] .
                ',
    pSign: \'' .
                $config['currency_symbol_position'] .
                '\',
    aDec: \'' .
                $config['dec_point'] .
                '\',
    aSep: \'' .
                $config['thousands_sep'] .
                '\'

    });

        '
        );

        $ui->assign('paginator', $paginator);
        $ui->display('transactions.tpl');
        break;

    case 'manage':
        Event::trigger('transactions/manage/');

        $id = $routes['2'];
        $t = ORM::for_table('sys_transactions')->find_one($id);
        if ($t) {
            $p = ORM::for_table('crm_accounts')->find_many();
            $ui->assign('p', $p);
            $ui->assign('t', $t);
            $d = ORM::for_table('sys_accounts')->find_many();
            $ui->assign('d', $d);
            $icat = '1';
            if ($t['type'] == 'Income') {
                $cats = ORM::for_table('sys_cats')
                    ->where('type', 'Income')
                    ->find_many();
                $tags = Tags::get_all('Income');
            } elseif ($t['type'] == 'Expense') {
                $cats = ORM::for_table('sys_cats')
                    ->where('type', 'Expense')
                    ->find_many();
                $tags = Tags::get_all('Expense');
            } else {
                $cats = '0';
                $icat = '0';
                $tags = Tags::get_all('Transfer');
            }

            $ui->assign('tags', $tags);
            $dtags = explode(',', $t['tags']);
            $ui->assign('dtags', $dtags);
            $ui->assign('icat', $icat);
            $ui->assign('cats', $cats);
            $pms = ORM::for_table('sys_pmethods')->find_many();
            $ui->assign('pms', $pms);

            $ui->assign('mdate', $mdate);
            $ui->assign(
                'xheader',
                Asset::css(['s2/css/select2.min', 'dp/dist/datepicker.min'])
            );
            $ui->assign(
                'xfooter',
                Asset::js([
                    's2/js/select2.min',
                    's2/js/i18n/' . lan(),
                    'dp/dist/datepicker.min',
                    'dp/i18n/' . $config['language'],
                    'numeric',
                    'tr-manage',
                ])
            );
            $ui->display('manage-transaction.tpl');
        } else {
            r2(U . 'transactions/list', 'e', $_L['Transaction_Not_Found']);
        }

        break;

        

    case 'post':
        break;

    case 's':
        Event::trigger('transactions/s/');
        $d = ORM::for_table('sys_accounts')->find_many();
        // $p = ORM::for_table('sys_payers')->find_many();
        $c = ORM::for_table('crm_accounts')->find_many();
        $ui->assign('c', $c);
        $ui->assign('d', $d);
        $cats = ORM::for_table('sys_cats')
            ->where('type', 'Income')
            ->order_by_asc('sorder')
            ->find_many();
        $ui->assign('cats', $cats);
        $pms = ORM::for_table('sys_pmethods')->find_many();
        $ui->assign('pms', $pms);
        $mdate = date('Y-m-d');
        $fdate = date('Y-m-d', strtotime('today - 30 days'));
        $ui->assign('fdate', $fdate);
        $ui->assign('tdate', $mdate);
        $ui->assign(
            'xheader',
            Asset::css([
                's2/css/select2.min',
                'dp/dist/datepicker.min',
                'modal',
            ])
        );
        $ui->assign(
            'xfooter',
            Asset::js([
                's2/js/select2.min',
                's2/js/i18n/' . lan(),
                'dp/dist/datepicker.min',
                'dp/i18n/' . $config['language'],
                'numeric',
                'modal',
                'js/tra',
            ])
        );

        $ui->display('trs.tpl');

        break;

    case 'export_csv':
        Event::trigger('transactions/export_csv/');

        $fileName = 'transactions_' . time() . '.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen('php://output', 'w');

        $headerDisplayed = false;

        $results = db_find_array('sys_transactions');

        foreach ($results as $data) {
            // Add a header row if it hasn't been added yet
            if (!$headerDisplayed) {
                // Use the keys from $data as the titles
                fputcsv($fh, array_keys($data));
                $headerDisplayed = true;
            }

            // Put the data into the stream
            fputcsv($fh, $data);
        }
        // Close the file
        fclose($fh);

        break;

    case 'handle_attachment':
        $uploader = new Uploader();
        $uploader->setDir('application/storage/transactions/');
        $uploader->sameName(false);
        $uploader->setExtensions(['jpg', 'jpeg', 'png', 'gif', 'pdf']); //allowed extensions list//
        if ($uploader->uploadFile('file')) {
            //txtFile is the filebrowse element name //
            $uploaded = $uploader->getUploadName(); //get uploaded file name, renames on upload//

            $file = $uploaded;
            $msg = 'Uploaded Successfully';
            $success = 'Yes';
        } else {
            //upload failed
            $file = '';
            $msg = $uploader->getMessage();
            $success = 'No';
        }

        $a = [
            'success' => $success,
            'msg' => $msg,
            'file' => $file,
        ];

        header('Content-Type: application/json');

        echo json_encode($a);

        break;

    default:
        echo 'action not defined';
}
