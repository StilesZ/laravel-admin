<section class="wrapper-bottom-sec">
    <div class="p-30">
        <h2 class="page-title">{{language_data('English To')}} {{$lan_name}}</h2>
    </div>
    <div class="p-30 p-t-none p-b-none">

        <div class="row">
            <form method="post" action="{{url('admin/translate',['id'=>$lid])}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="lan_id" value="{{$lid}}">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
{{--                            <h3 class="panel-title">{{language_data('English To')}} {{$lan_name}}</h3>--}}
                            <button class="btn btn-success btn-sm pull-left" id="load_more"><i class="fa fa-add"></i> {{language_data('Load More')}}</button>
                            <button class="btn btn-success btn-sm pull-right" type="submit"><i class="fa fa-save"></i> {{language_data('Save')}}</button>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 50%;" class="text-center">{{language_data('English')}}</th>
                                    <th style="width: 50%;" class="text-center">{{$lan_name}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lan_data as $key => $ld)
                                    <tr>
                                        <td data-label="{{language_data('English')}}"><p><input  type="hidden" name="english_data[]" value="{{$key}}"> {{$key}}</p></td>
                                        <td data-label="{{$lan_name}}"><p><input type="text" class="form-control" required="" name="translate_data[]" value="{{$ld}}"></p></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $('#load_more').click(function () {
        $('table').append('' +
            '<tr>\n' +
            '<td data-label=""><p><input type="text" class="form-control" required="" name="english_data[]" value=""></p></td>\n' +
            '<td data-label=""><p><input type="text" class="form-control" required="" name="translate_data[]" value=""></p></td>\n' +
            '</tr>'
        )
    });
</script>
