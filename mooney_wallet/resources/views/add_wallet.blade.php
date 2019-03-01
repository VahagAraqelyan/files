@extends('layouts.app')

@section('content')
    <form method="post" autocomplete="off" id="add_wallet_form">
        <div class="add_more_fields">
            <div class="col-md-12 wallet_block">
                <div class="list-item-area new-adding-place my_list_class">
                    <div class="col-md-3 list-input">
                        <input type="text" name="names[]" value="" class="form-control wallet_name" placeholder="">
                    </div>
                    <div class="col-md-3 list-input">
                        <select class="form-control selectpicker wallet_type" name="types[]" tabindex="-98">
                            <option value="1">Credit Card</option>
                            <option value="2">Cash</option>
                        </select>
                    </div>
                    <div class="item-delete col-md-2"><a href="#" class="remove_wallet">X</a></div>
                </div>
            </div>

        </div>
    </form>

    <div class="col-md-6 add_new">
        <a href="#" class="add-more-item">Add More Item</a>
    </div>

    <div class="col-2 value-info">
        <button type="button" class="btn save_wallet">Add Wallet</button>
    </div>
@endsection