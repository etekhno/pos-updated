<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dashed black;}
        td,th {padding: 7px 0;width: 50%; border-right: 1px solid black; border-left: 1px solid black; text-align:left;padding: 8px;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media print {
            * {
                font-size:11px;
                line-height: 18px;
            }
            td,th {padding: 1px 5px;}
            .hidden-print {
                display: none !important;
            }
            @page { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; } 
        }
    </style>
  </head>
<body>

<div style="max-width:400px;margin:0 auto">
    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../../pos'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td style="border:none;"><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('file.Back')}}</a> </td>
                <td style="border:none;"><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('file.Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>
        
    <div id="receipt-data">
        <div class="centered">
            @if($general_setting->site_logo)
                <img src="{{url('public/logo', $general_setting->site_logo)}}" height="42" width="42" style="margin:10px 0;filter: brightness(0);">
            @endif
            
            <h2>{{$lims_biller_data->company_name}}</h2>
            
            <p>{{trans('file.Address')}}: {{$lims_warehouse_data->address}}
                <br>{{trans('file.Phone Number')}}: {{$lims_warehouse_data->phone}}
            </p>
        </div>
        <p>{{trans('file.Date')}}: {{$lims_sale_data->created_at}}<br>
            {{trans('file.reference')}}: {{$lims_sale_data->reference_no}}<br>
            {{trans('file.customer')}}: {{$lims_customer_data->name}}
        </p>
        @if(strpos($url, '/pos/sales') === false)

        <table>
            <thead>
                <tr style="border-top:solid 1px; border-bottom:solid 1px" >
                    <th colspan="4">
                        <table>
                            <tr>
                                <th style="border:none">{{trans('file.Current Due Amount')}}</th>
                                <th style="text-align:right; border:none">{{number_format((float)$lims_sale_data->grand_total)}}</th>
                            </tr>
                            <tr>
                                <th style="border:none">{{trans('file.Previous Due Amount')}}</th>
                                <th style="text-align:right; border:none">{{ $dues - $lims_sale_data->grand_total }}</th>
                            </tr>
                            <tr style="border:none;">
                                <th style="border:none">{{trans('file.Total Due Amount')}}</th>
                                <th style="text-align:right; color:red; border:none">{{ $dues }}</th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr  style="border:none"><th colspan="4" style="border:none"></th></tr>
                <tr  style="border:none"><th colspan="4" style="border:none"></th></tr>
                <tr  style="border-top:solid 1px">
                    <th>{{trans('file.Item')}}</th>
                    <th>{{trans('file.Rate')}}</th>
                    <th>{{trans('file.Qty')}}</td>
                    <th style="text-align:right;vertical-align:bottom">{{trans('file.Amount')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_product_sale_data as $product_sale_data)
                @php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                @endphp
                <tr>
                    <td> {{$product_name}}</td> 
                    <td> {{number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', '')}}</td>
                    <td> {{$product_sale_data->qty}} </td>
                    <td style="text-align:right;vertical-align:bottom"> {{number_format((float)$product_sale_data->total, 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">{{trans('file.Total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->total_price, 2, '.', '')}}</th>
                </tr>
                @if($lims_sale_data->order_tax)
                <tr>
                    <th colspan="3">{{trans('file.Order Tax')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_tax, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->order_discount)
                <tr>
                    <th colspan="3">{{trans('file.Order Discount')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_discount, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->coupon_discount)
                <tr>
                    <th colspan="3">{{trans('file.Coupon Discount')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->coupon_discount, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->shipping_cost)
                <tr>
                    <!-- <th colspan="3">{{trans('file.Shipping Cost')}}</th> -->
                    <th colspan="3">{{trans('file.Loading Cost')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->shipping_cost, 2, '.', '')}}</th>
                </tr>
                @endif
                <tr>
                    <th colspan="3">{{trans('file.grand total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->grand_total, 2, '.', '')}}</th>
                </tr>
                <tr>
                    @if($general_setting->currency_position == 'prefix')
                    <th class="centered" colspan="4">{{trans('file.In Words')}}: <span>{{$general_setting->currency}}</span> <span>{{str_replace("-"," ",$numberInWords)}}</span></th>
                    @else
                    <th class="centered" colspan="4">{{trans('file.In Words')}}: <span>{{str_replace("-"," ",$numberInWords)}}</span> <span>{{$general_setting->currency}}</span></th>
                    @endif
                </tr>
            </tfoot>
        </table>
        @endif
        <table>
            <tbody>
                @if(strpos($url, '/pos/sales') !== false)
                    <p class="centered" ><b><u>{{ 'Client Payment History' }}</u></b></p>
                    <tr><th colspan="2"> {{ 'Current Bill Amount: ' }} </th> <th style="text-align:right"> <u>{{$lims_sale_data->grand_total }}</u> </th></tr>
                @endif

                @foreach($lims_payment_data as $payment_data)
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%">{{trans('file.Paid By')}}: {{$payment_data->paying_method}}</td>
                    <td style="padding: 5px;width:40%">{{trans('file.Amount')}}: {{number_format((float)$payment_data->amount, 2, '.', '')}}</td>
                    <td style="padding: 5px;width:30%">{{trans('file.Change')}}: {{number_format((float)$payment_data->change, 2, '.', '')}}</td>
                </tr>
                <tr>
                    <th colspan="2">{{trans('file.Due Amount')}}: : {{$payment_data->created_at->format('d-m-Y')}}</th>
                    @php
                        $lims_sale_data->grand_total = number_format((float)$lims_sale_data->grand_total - (float)$payment_data->amount, 2, '.', '');
                    @endphp
                    <!-- <th style="text-align:right">{{number_format((float)$lims_sale_data->grand_total - (float)$payment_data->amount, 2, '.', '')}}</th> -->
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->grand_total)}}</th>
                </tr>
                <!-- <tr><td class="centered" colspan="3">{{trans('file.Thank you for shopping with us.')}}<br>{{trans('file.Will be happy to see you again.')}}</td></tr> -->
                @endforeach
                @if(true)
                <!-- <tr>
                    <th colspan="2">{{trans('file.Total Due Amount')}}</th>
                    <th style="text-align:right">{{ $dues }}</th>
                </tr> -->
                <tr><td class="centered" colspan="3">{{trans('file.Thank you for shopping with us.')}}<br>{{trans('file.Will be happy to see you again.')}}</td></tr>
                @endif
            </tbody>
        </table>
        <!-- <div class="centered" style="margin:30px 0 50px">
            <small>{{trans('file.Invoice Generated By')}} {{$general_setting->site_title}}.
            {{trans('file.Developed By')}} LionCoders</strong></small>
        </div> -->
    </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
