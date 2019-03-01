@extends('layouts.app')

@section('content')
    <div class="col-md-6 add_new">
        <form method="post" id="add_records_form" autocomplete="off">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Records type</label>
                <select class="form-control selectpicker wallet_type" name="record_type" tabindex="-98">
                    <option value="1">Income </option>
                    <option value="2">Expense</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Wallet type</label>
                <select class="form-control selectpicker wallet_type" name="wallet_type" tabindex="-98">
                    <?php
                        if(!empty($wallets)){
                            foreach ($wallets as $single){ ?>
                             <option value="<?php echo $single['id']; ?>"><?php echo $single['name']; ?> </option>
                            <?php } } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" class="form-control number_class" name="price">
            </div>
            <button type="button" class="btn btn-primary save_records">Add Records</button>
        </form>
    </div>
@endsection
