@extends('layouts.app')

@section('content')
    <div class="container">
        <?php
        $type_arr = [
            '1' => 'Credit Card',
            '2' => 'Cash'
        ];
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading flex_cl">
                        <p>All Wallets </p>
                        <a class="" href="{{ url('/add_Wallet') }}">
                            Add Wallet
                        </a>
                    </div>
                    <div class="panel-body">
                        <?php
                        if(!empty($wallets)){
                        foreach ($wallets as $single){ ?>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $single['name']; ?></h5>
                                    <p class="card-text"><?php echo $type_arr[$single['type']]; ?></p>
                                    <p class="card-text"><?php echo $single['amount']; ?></p>
                                </div>
                            </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
