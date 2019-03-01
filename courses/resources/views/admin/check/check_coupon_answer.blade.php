<div class="admin_main_content">
    <form action="" id="save_coupon_form" method="post">

    @if(!empty($users))
        @foreach($users as  $index => $single)
            <div class="my-form-group">
                <div class="col-md-12 value-info">
                    <label for="">{{$single['name']}}</label>
                    <select name="check_coupon[{{$single['id']}}]" class="form-control">
                        <?php
                            $k = ($single['payment_charge'] == 1)?'selected':'';
                            $m = ($single['payment_charge'] == 2)?'selected':'';
                        ?>
                        <option {{$k}} value="1">Unverify</option>
                        <option {{$m}} value="2">Verify</option>
                    </select>
                </div>
            </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for="">Name</label>
                        <input type="text" name="name[{{$single['id']}}]" value="{{$single['name']}}">
                    </div>
                </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for="">Email</label>
                        <input type="text" name="email[{{$single['id']}}]" value="{{$single['email']}}">
                    </div>
                </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for="">Shcool year</label>
                        <input type="text" name="shcool_year[{{$single['id']}}]" value="{{$single['shcool_year']}}">
                    </div>
                </div>
         @endforeach
            <div class="my-form-group">
                <div class="col-md-12 value-info">
                    <button type="button" class="save_check_coupon btn btn-primary ">Check Coupon</button>
                </div>
            </div>
    </form>
    @endif

    </div>

