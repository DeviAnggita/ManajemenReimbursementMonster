// public function update(Request $request, $id_user)
// {
// $karyawan = User::findOrFail($id_user);

// $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan', $request->nomor_identitas_karyawan)
// ->where('id_user', '!=', $id_user)
// ->first();

// $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
// ->where('id_user', '!=', $id_user)
// ->first();

// $divisi = User::where('id_divisi', $request->id_divisi)
// ->where('id_user', '!=', $id_user)
// ->first();

// $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
// ->where('id_divisi', $request->id_divisi)
// ->where('id_user', '!=', $id_user)
// ->first();

// if ($nomor_identitas_karyawan) {
// return redirect()
// ->route('karyawan.index')
// ->with([
// Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
// ]);
// } else if ($email_karyawan) {
// return redirect()
// ->route('karyawan.index')
// ->with([
// Alert::error('Gagal', 'Email Karyawan Sudah Ada')
// ]);
// } else if ($existingKaryawan) {
// return redirect()
// ->route('karyawan.index')
// ->with([
// Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
// ]);
// }

// $superAdminCount = User::where('id_role', 1)
// ->where('status_active', '!=', 0)
// ->where('id_user', '!=', $id_user) // Exclude the current user from the count
// ->count();
// // dd($superAdminCount);

// if ($superAdminCount <= 0) { // Change the condition to check for <=0 // return redirect() // ->
    route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Setidaknya ada satu SuperAdmin yang statusnya aktif')
    // ]);
    // } else {
    // $status_active = $request->has('status_active') ? 1 : 0;

    // $karyawan->id_divisi = $request->id_divisi;
    // $karyawan->id_strata = $request->id_strata;
    // $karyawan->id_role = $request->id_role;
    // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
    // $karyawan->nama_karyawan = $request->nama_karyawan;
    // $karyawan->email_karyawan = $request->email_karyawan;
    // $karyawan->password = Hash::make($request->password);
    // $karyawan->gaji = str_replace('.', '', $request->gaji);
    // $karyawan->status_active = $status_active;

    // $karyawan->save();

    // if ($karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
    // ]);
    // } else {
    // return redirect()
    // ->back()
    // ->withInput()
    // ->with([
    // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
    // ]);
    // }
    // }
    // }



    ==============================================










    // public function update(Request $request, $id_user)
    // {
    // $karyawan = User::findOrFail($id_user);

    // $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan', $request->nomor_identitas_karyawan)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $divisi = User::where('id_divisi', $request->id_divisi)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
    // ->where('id_divisi', $request->id_divisi)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // if ($nomor_identitas_karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
    // ]);
    // } else if ($email_karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Email Karyawan Sudah Ada')
    // ]);
    // } else if ($existingKaryawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
    // ]);
    // }

    // // $this->validate($request, [
    // // 'id_divisi' => 'required',
    // // 'id_strata' => 'required',
    // // 'id_role' => 'required',
    // // 'nomor_identitas_karyawan' => 'required|min:10|max:10',
    // // 'nama_karyawan' => 'required',
    // // 'email_karyawan' => 'required|email',
    // // 'password' => 'required|min:8',
    // // 'gaji' => 'required',
    // // ]);

    // $status_active = $request->has('status_active') ? 1 : 0;

    // $karyawan->id_divisi = $request->id_divisi;
    // $karyawan->id_strata = $request->id_strata;
    // $karyawan->id_role = $request->id_role;
    // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
    // $karyawan->nama_karyawan = $request->nama_karyawan;
    // $karyawan->email_karyawan = $request->email_karyawan;
    // $karyawan->password = Hash::make($request->password);
    // $karyawan->gaji = str_replace('.', '', $request->gaji);
    // $karyawan->status_active = $status_active;

    // $karyawan->save();

    // if ($karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
    // ]);
    // } else {
    // return redirect()
    // ->back()
    // ->withInput()
    // ->with([
    // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
    // ]);
    // }
    // }


    // public function update(Request $request, $id_user)
    // {
    // $karyawan = User::findOrFail($id_user);

    // $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan', $request->nomor_identitas_karyawan)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $divisi = User::where('id_divisi', $request->id_divisi)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
    // ->where('id_divisi', $request->id_divisi)
    // ->where('id_user', '!=', $id_user)
    // ->first();

    // if ($nomor_identitas_karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
    // ]);
    // } else if ($email_karyawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Email Karyawan Sudah Ada')
    // ]);
    // } else if ($existingKaryawan) {
    // return redirect()
    // ->route('karyawan.index')
    // ->with([
    // Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
    // ]);
    // }

    // $superAdminCount = User::where('id_role', 1)
    // ->where('status_active', '!=', 0)
    // ->count();
    // // dd($superAdminCount);

    // if ($superAdminCount <= 1) { // return redirect() // ->route('karyawan.index')
        // ->with([
        // Alert::error('Gagal', 'Setidaknya ada satu SuperAdmin yang status nya active')
        // ]);
        // }else{

        // $status_active = $request->has('status_active') ? 1 : 0;

        // $karyawan->id_divisi = $request->id_divisi;
        // $karyawan->id_strata = $request->id_strata;
        // $karyawan->id_role = $request->id_role;
        // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
        // $karyawan->nama_karyawan = $request->nama_karyawan;
        // $karyawan->email_karyawan = $request->email_karyawan;
        // $karyawan->password = Hash::make($request->password);
        // $karyawan->gaji = str_replace('.', '', $request->gaji);
        // $karyawan->status_active = $status_active;

        // $karyawan->save();

        // if ($karyawan) {
        // return redirect()
        // ->route('karyawan.index')
        // ->with([
        // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
        // ]);
        // } else {
        // return redirect()
        // ->back()
        // ->withInput()
        // ->with([
        // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
        // ]);
        // }
        // }
        // }

        // public function update(Request $request, $id_user)
        // {
        // $karyawan = User::findOrFail($id_user);

        // $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan', $request->nomor_identitas_karyawan)
        // ->where('id_user', '!=', $id_user)
        // ->first();

        // $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
        // ->where('id_user', '!=', $id_user)
        // ->first();

        // $divisi = User::where('id_divisi', $request->id_divisi)
        // ->where('id_user', '!=', $id_user)
        // ->first();

        // $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
        // ->where('id_divisi', $request->id_divisi)
        // ->where('id_user', '!=', $id_user)
        // ->first();

        // if ($nomor_identitas_karyawan) {
        // return redirect()
        // ->route('karyawan.index')
        // ->with([
        // Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
        // ]);
        // } else if ($email_karyawan) {
        // return redirect()
        // ->route('karyawan.index')
        // ->with([
        // Alert::error('Gagal', 'Email Karyawan Sudah Ada')
        // ]);
        // } else if ($existingKaryawan) {
        // return redirect()
        // ->route('karyawan.index')
        // ->with([
        // Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
        // ]);
        // }

        // $superAdminCount = User::where('id_role', 1)
        // ->where('status_active', '!=', 0)
        // ->where('id_user', '!=', $id_user) // Exclude the current user from the count
        // ->count();
        // // dd($superAdminCount);

        // if ($superAdminCount <= 0) { // Change the condition to check for <=0 // return redirect() // ->
            route('karyawan.index')
            // ->with([
            // Alert::error('Gagal', 'Setidaknya ada satu SuperAdmin yang statusnya aktif')
            // ]);
            // } else {
            // $status_active = $request->has('status_active') ? 1 : 0;

            // $karyawan->id_divisi = $request->id_divisi;
            // $karyawan->id_strata = $request->id_strata;
            // $karyawan->id_role = $request->id_role;
            // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
            // $karyawan->nama_karyawan = $request->nama_karyawan;
            // $karyawan->email_karyawan = $request->email_karyawan;
            // $karyawan->password = Hash::make($request->password);
            // $karyawan->gaji = str_replace('.', '', $request->gaji);
            // $karyawan->status_active = $status_active;

            // $karyawan->save();

            // if ($karyawan) {
            // return redirect()
            // ->route('karyawan.index')
            // ->with([
            // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
            // ]);
            // } else {
            // return redirect()
            // ->back()
            // ->withInput()
            // ->with([
            // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
            // ]);
            // }
            // }
            // }



            // public function update(Request $request, $id_user)
            // {
            // // dd($request->all());
            // $karyawan = User::findOrFail($id_user);

            // $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan', $request->nomor_identitas_karyawan)
            // ->where('id_user', '!=', $id_user)
            // ->first();

            // $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
            // ->where('id_user', '!=', $id_user)
            // ->first();

            // $divisi = User::where('id_divisi', $request->id_divisi)
            // ->where('id_user', '!=', $id_user)
            // ->first();

            // $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
            // ->where('id_divisi', $request->id_divisi)
            // ->where('id_user', '!=', $id_user)
            // ->first();

            // if ($nomor_identitas_karyawan) {
            // return redirect()
            // ->route('karyawan.index')
            // ->with([
            // Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
            // ]);
            // } else if ($email_karyawan) {
            // return redirect()
            // ->route('karyawan.index')
            // ->with([
            // Alert::error('Gagal', 'Email Karyawan Sudah Ada')
            // ]);
            // } else if ($existingKaryawan) {
            // return redirect()
            // ->route('karyawan.index')
            // ->with([
            // Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
            // ]);
            // }

            // $superAdminCount = User::where('id_role', 1)
            // ->where('status_active', '!=', 0)
            // ->where('id_user', '!=', $id_user) // Exclude the current user from the count
            // ->count();
            // // dd($superAdminCount);

            // if ($superAdminCount <= 1) { // Change the condition to check for <=0 // return redirect() // ->
                route('karyawan.index')
                // ->with([
                // Alert::error('Gagal', 'Setidaknya ada satu SuperAdmin yang statusnya aktif')
                // ]);
                // } else {

                // $status_active = $request->has('status_active') ? 1 : 0;

                // $karyawan->id_divisi = $request->id_divisi;
                // $karyawan->id_strata = $request->id_strata;
                // $karyawan->id_role = $request->id_role;
                // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
                // $karyawan->nama_karyawan = $request->nama_karyawan;
                // $karyawan->email_karyawan = $request->email_karyawan;

                // if ($request->has('password')) {
                // // Only update the password if a new password is provided
                // $karyawan->password = Hash::make($request->password);
                // // $karyawan->password = $request->password;
                // }


                // $karyawan->gaji = str_replace('.', '', $request->gaji);
                // $karyawan->status_active = $status_active;

                // $karyawan->save();

                // if ($karyawan) {
                // return redirect()
                // ->route('karyawan.index')
                // ->with([
                // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
                // ]);
                // } else {
                // return redirect()
                // ->back()
                // ->withInput()
                // ->with([
                // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
                // ]);
                // }
                // }
                // }

                // public function update(Request $request, $id_user)
                // {
                // $karyawan = User::findOrFail($id_user);

                // $nomor_identitas_karyawan = User::where('nomor_identitas_karyawan',
                $request->nomor_identitas_karyawan)
                // ->where('id_user', '!=', $id_user)
                // ->first();

                // $email_karyawan = User::where('email_karyawan', $request->email_karyawan)
                // ->where('id_user', '!=', $id_user)
                // ->first();

                // $divisi = User::where('id_divisi', $request->id_divisi)
                // ->where('id_user', '!=', $id_user)
                // ->first();

                // $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
                // ->where('id_divisi', $request->id_divisi)
                // ->where('id_user', '!=', $id_user)
                // ->first();

                // if ($nomor_identitas_karyawan) {
                // return redirect()
                // ->route('karyawan.index')
                // ->with([
                // Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
                // ]);
                // } else if ($email_karyawan) {
                // return redirect()
                // ->route('karyawan.index')
                // ->with([
                // Alert::error('Gagal', 'Email Karyawan Sudah Ada')
                // ]);
                // } else if ($existingKaryawan) {
                // return redirect()
                // ->route('karyawan.index')
                // ->with([
                // Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
                // ]);
                // }

                // $superAdminCount = User::where('id_role', 1)
                // ->where('status_active', '!=', 0)
                // ->count();
                // // dd($superAdminCount);

                // if ($superAdminCount <= 1) { // return redirect() // ->route('karyawan.index')
                    // ->with([
                    // Alert::error('Gagal', 'Setidaknya ada satu SuperAdmin yang status nya active')
                    // ]);
                    // }else{


                    // $status_active = $request->has('status_active') ? 1 : 0;

                    // $karyawan->id_divisi = $request->id_divisi;
                    // $karyawan->id_strata = $request->id_strata;
                    // $karyawan->id_role = $request->id_role;
                    // $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
                    // $karyawan->nama_karyawan = $request->nama_karyawan;
                    // $karyawan->email_karyawan = $request->email_karyawan;
                    // $karyawan->password = Hash::make($request->password);
                    // $karyawan->gaji = str_replace('.', '', $request->gaji);
                    // $karyawan->status_active = $status_active;

                    // $karyawan->save();

                    // if ($karyawan) {
                    // return redirect()
                    // ->route('karyawan.index')
                    // ->with([
                    // Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah')
                    // ]);
                    // } else {
                    // return redirect()
                    // ->back()
                    // ->withInput()
                    // ->with([
                    // Alert::error('Gagal', 'Data Karyawan Gagal Diubah')
                    // ]);
                    // }
                    // }
                    // }