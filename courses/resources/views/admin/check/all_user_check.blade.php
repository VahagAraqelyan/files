@extends('admin/layouts.adminDashboard');

@section('content')
    <?php
        $Plan = [
            '1' => 'Free',
            '2' => 'Premium',
        ];

        $payment_charge = [
            '1' => 'No',
            '2' => 'Yes',
        ];
    ?>
    <div class="admin_main_content">
        <button class="btn_style check_coupon btn-default ">Edit</button>
        <button class="btn_style btn-default delete_user">delete</button>
        <table class="table table-bordered table-hover designed-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>email</th>
                    <th>Shcool Year</th>
                    <th>Plan</th>
                    <th>Avatar</th>
                    <th>Charge</th>
                    <th>Check</th>
                    <th>Edit/Delete</th>
                </tr>
            </thead>
            @if(!empty($users))
                @foreach($users as $index => $single)
                   <tbody>
                       <tr>
                           <td>{{$index+1}}</td>
                           <td>{{$single['name']}}</td>
                           <td>{{$single['email']}}</td>
                           <td>{{$single['shcool_year']}}</td>
                           <td>
                               @if(!empty($single['plan_id']))
                                   {{$Plan[$single['plan_id']]}}
                               @endif
                           </td>
                           <td>
                               @if(!empty($single['user_avatar']))
                                   <img src="{{asset('user/'.$single['id'].'/'.$single['user_avatar'])}}" alt="">
                               @endif
                           </td>
                           <td>
                               @if(!empty($single['payment_charge']))
                                {{$payment_charge[$single['payment_charge']]}}
                               @endif
                           </td>
                           <td>
                               @if(!empty($single['charge_check']))
                                   <img class="check_img" src="{{asset('user/'.$single['id'].'/'.$single['charge_check'])}}" alt="">
                                @endif
                           </td>
                           <td>
                               <label>
                                    <input type="checkbox" class="edit_delete_user" value="{{$single['id']}}">
                                   <span class="checkmark"></span></label>
                               </label>

                           </td>
                       </tr>
                   </tbody>
                @endforeach
            @endif
        </table>
    </div>

    <div class="modal fade" id="img_zoom_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="message"></div>
                <div class="modal-body img_zoom">
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="check_coupon_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="message"></div>
                <div class="modal-body check_coupon_answer">
                </div>
            </div>
        </div>
    </div>
@endsection
