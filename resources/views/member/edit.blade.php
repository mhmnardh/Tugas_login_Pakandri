@extends(session()->has('user_id') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Edit Member')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0 fs-5">Edit Member</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('member.update', $member->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama_member" class="form-label">Nama Member</label>
                                    <input type="text" class="form-control @error('nama_member') is-invalid @enderror"
                                        id="nama_member" name="nama_member"
                                        value="{{ old('nama_member', $member->nama_member) }}" required>
                                    @error('nama_member')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $member->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No Telepon</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                        id="no_telepon" name="no_telepon"
                                        value="{{ old('no_telepon', $member->no_telepon) }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $member->tanggal_lahir) }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="foto_member" class="form-label">Foto Member</label>
                                    @if ($member->foto_member)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $member->foto_member) }}" alt="Foto Saat Ini"
                                                class="img-thumbnail" style="height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_member') is-invalid @enderror"
                                        id="foto_member" name="foto_member" accept="image/*">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                                    @error('foto_member')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-warning">Perbarui Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
