<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //

    public function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai',$theloai);
        view()->share('slide',$slide);
    }

    public function trangchu()
    {
        return view('pages.trangchu');
    }

    public function lienhe()
    {
        return view('pages.lienhe');
    }

    public function loaitin(LoaiTin $loaitin)
    {
        $tintuc = TinTuc::where('idLoaiTin',$loaitin->id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }

    public function tintuc(TinTuc $tintuc)
    {
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }

    public function getDangnhap(){
        return view('pages.dangnhap');
    }
    public function postDangnhap(Request $request){
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập password'
            ]
        );
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('trangchu');
        }
        else{
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getDangXuat(){
        Auth::logout();
        return redirect('trangchu');
    }

    public function getNguoiDung()
    {
        return view('pages.nguoidung');
    }
    public function postNguoiDung(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|min:3',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự', 
        ]
        );
        $user = Auth::user();
        $user->name =$request->name;  

        if($request->changePassword=='on'){
            $this->validate($request,
                [
                    'password' => 'required|min:3',
                    'passwordAgain' => 'required|same:password'
                ],
                [
                    'password.required' => 'Bạn chưa nhập mật khẩu',
                    'password.min' => 'Mật khẩu ít nhất 3 ký tự',
                    
                    'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                    'passwordAgain.same' => 'Mật khẩu nhập lại không khớp',
                ]
            );
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect("nguoidung")->with('thongbao','Sửa thành công');
    }

    public function getDangKy()
    {
        return view('pages.dangky');
    }
    public function postDangKy(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'passwordAgain' => 'required|same:password'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
            
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',

            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu ít nhất 3 ký tự',
            
            'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
            'passwordAgain.same' => 'Mật khẩu nhập lại không khớp',
        ]
        );

        $user  = new User;
        $user->name =$request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;

        $user->save();
        return redirect('dangky')->with('thongbao','Đăng ký thành công');
    }

    public function timkiem(Request $request)
    {
        $tukhoa = $request->TuKhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->paginate(5);
        return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }

}
