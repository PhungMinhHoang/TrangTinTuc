<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc;
use App\TheLoai;
use App\LoaiTin;

class TinTucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
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
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,
        [
            'LoaiTin' => 'required',
            'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
            'TomTat' => 'required',
            'NoiDung' => 'required',
        ],
        [   
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
            'TieuDe.min' => 'Tiêu đề phải có ít nhất 3 ký tư',
            'TieuDe.unique' => 'Tiêu đề đã tồn tại',
            'TomTat.required' => 'Bạn chưa nhập tóm tắt',
            'NoiDung.required' => 'Bạn chưa nhập nội dung',
        ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi !='jpg' && $duoi !='png'){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg/png');
            }
            $name = $file->getClientOriginalName();
            $Hinh = idate("U")."-".$name; 
            $file->move('upload/tintuc',$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else{
            $tintuc->Hinh ='';
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Thêm tin thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TinTuc $tintuc)
    {
        //
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return View('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,TinTuc $tintuc)
    {
        $this->validate($request,
        [
            'LoaiTin' => 'required',
            'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
            'TomTat' => 'required',
            'NoiDung' => 'required',
        ],
        [   
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
            'TieuDe.min' => 'Tiêu đề phải có ít nhất 3 ký tư',
            'TieuDe.unique' => 'Tiêu đề đã tồn tại',
            'TomTat.required' => 'Bạn chưa nhập tóm tắt',
            'NoiDung.required' => 'Bạn chưa nhập nội dung',
        ]);

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi !='jpg' && $duoi !='png'){
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg/png');
            }
            $name = $file->getClientOriginalName();
            $Hinh = idate("U")."-".$name; 
            $file->move('upload/tintuc',$Hinh);
            unlink("upload/tintuc/$tintuc->Hinh");
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->save();
        return redirect("admin/tintuc/sua/$tintuc->id")->with('thongbao','Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TinTuc $tintuc)
    {
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
    }
}
