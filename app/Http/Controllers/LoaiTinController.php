<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $theloai = TheLoai::all();
        return view('admin.loaitin.them',['theloai'=>$theloai]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'Ten' => 'required|unique:loaitin,Ten|min:3|max:100',
            'TheLoai' => 'required'
        ],
        [   
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.unique' => 'Tên loại tin đã tồn tại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',

            'TheLoai.required' => 'Bạn chưa chọn thể loại',
        ]);

        $loaitin = new LoaiTin();
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao','Thêm thành công');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LoaiTin $loaitin)
    {
        //
        $theloai = TheLoai::all();
        return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LoaiTin $loaitin,Request $request)
    {
        //
        $this->validate($request,
        [
            'Ten' => 'required|unique:loaitin,Ten|min:3|max:100',
            'TheLoai' => 'required'
        ],
        [   
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.unique' => 'Tên loại tin đã tồn tại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',

            'TheLoai.required' => 'Bạn chưa chọn thể loại',
        ]);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/'.$loaitin->id)->with('thongbao','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoaiTin $loaitin)
    {
        //
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
