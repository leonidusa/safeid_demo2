<html>
    <body>
        <h2>Thank you for purchasing {{ $payment_info->transactions[0]->item_list->items[0]->name }}</h2>
        <h3>Invoice {{ $payment_info->transactions[0]->invoice_number }}</h3>
    </body>
</html>