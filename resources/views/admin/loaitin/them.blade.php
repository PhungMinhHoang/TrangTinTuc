@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại tin
                    <small>thêm</small>
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

                <form action="admin/loaitin/them" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Thể loại</label>
                        <select class="form-control" name="TheLoai" id="">
                          @foreach ($theloai as $tl)
                        <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tên thể loại</label>
                        <input class="form-control" name="Ten" placeholder="Nhập tên loại tin" />
                    </div>
                    
                    <button type="submit" class="btn btn-default">Thêm thể loại</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
