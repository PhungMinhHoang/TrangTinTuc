@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                <small>{{$tintuc->TieuDe}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if (count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $err)
                            {{$err}}<br>
                        @endforeach
                    </div>
                @endif

                @if (session('thongbao'))
                    <div class="alert alert-success" role="alert">
                        {{session('thongbao')}}
                    </div>
                @endif

                <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Thể loại</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            @foreach ($theloai as $tl)
                                <option 
                                    @if ($tintuc->loaitin->theloai->id == $tl->id)
                                        {{"selected"}}
                                    @endif
                                
                                value="{{$tl->id}}">{{$tl->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Loại tin</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            @foreach ($loaitin as $lt)
                                <option 
                                @if ($tintuc->loaitin->id == $lt->id)
                                            {{"selected"}}
                                        @endif
                                value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}"/>
                    </div>
                    <div class="form-group">
                      <label>Tóm tắt</label>
                      <textarea class="form-control ckeditor" name="TomTat" id="demo" rows="3">{{$tintuc->TomTat}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control ckeditor" name="NoiDung" id="demo" rows="5">{{$tintuc->NoiDung}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <p>
                                <img  width="400px" src="upload/tintuc/{{$tintuc->Hinh}}" alt="">
                        </p>
                        <input type="file" class="form-control-file" name="Hinh" id="" placeholder="" aria-describedby="fileHelpId">
                    </div>
                    <div class="form-group">
                        <label>Nổi bật </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="NoiBat" id="" value="checkedValue"
                                @if ($tintuc->NoiBat == 0)
                                    {{"checked"}}
                                @endif
                            > Không
                        </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="NoiBat" id="" value="checkedValue"
                                @if ($tintuc->NoiBat == 1)
                                    {{"checked"}}
                                @endif
                            > Có
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bình luận
                        <small>danh sách</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                @if (session('thongbao'))
                <div class="alert alert-success" role="alert">
                    {{session('thongbao')}}
                </div>
                @endif
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Nội dung</th>
                            <th>Ngày đăng</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tintuc->comment as $cm)
                            <tr class="odd gradeX" align="center">
                                <td>{{$cm->id}}</td>
                                <td>{{$cm->user->name}}</td>
                                <td>{{$cm->NoiDung}}</td>
                                <td>{{$cm->created_at}}</td>
                
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection

@section('script')
    <script>
        $('#TheLoai').change(function(){
            var idTheLoai = $(this).val();
            $.get(`admin/ajax/loaitin/${idTheLoai}`,function(data){
                $(`#LoaiTin`).html(data);
            })
        })
    </script>
@endsection
