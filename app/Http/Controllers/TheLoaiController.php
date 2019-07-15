<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.theloai.them');
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
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
        ],
        [   
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
        ]);

        $theloai = new TheLoai();
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');

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
    public function edit(TheLoai $theloai)
    {
        //
        return view('admin.theloai.sua',['theloai'=>$theloai]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TheLoai $theloai,Request $request)
    {
        //
        $this->validate($request,
        [
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
        ],
        [
            'Ten.required' => 'Bạn chưa nhập tên thể loại',
            'Ten.unique' => 'Thể loại đã tồn tại',
            'Ten.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
            'Ten.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 ký tự',
        ]);
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$theloai->id)->with('thongbao','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TheLoai $theLoai)
    {
        //
        $theLoai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}
