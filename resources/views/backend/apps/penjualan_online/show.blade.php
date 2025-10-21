<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />

 <!--begin::Informasi Umum-->
                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Kode Transaksi</label>
                        <div class="form-control form-control-solid fw-bold">{{ $data->kode_transaksi }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Tanggal Penjualan</label>
                        <div class="form-control form-control-solid fw-bold">
                            {{ $data->tanggal_penjualan?->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Kasir</label>
                        <div class="form-control form-control-solid fw-bold">
                            {{ $data->user?->name ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Kategori Penjualan</label>
                        <div class="form-control form-control-solid fw-bold text-uppercase">
                            {{ $data->kategori_penjualan ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Jenis Pembayaran</label>
                        <div class="form-control form-control-solid fw-bold">
                            {{ $data->jenis_pembayaran?->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold text-gray-600">Catatan</label>
                        <div class="form-control form-control-solid fw-bold">
                            {{ $data->catatan ?? '-' }}
                        </div>
                    </div>
                </div>
                <!--end::Informasi Umum-->

                <hr class="border-gray-300 my-6" />

                <!--begin::Detail Barang-->
                <h6 class="fw-bold mb-3 text-gray-800">
                    <i class="ki-outline ki-basket fs-3 text-primary me-1"></i>
                    Detail Barang
                </h6>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                            <tr class="fw-semibold text-gray-700">
                                <th>No</th>
                                <th>Kode Item</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data->detail as $no => $item)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $item->barang?->kode_barang ?? '-' }}</td>
                                    <td>{{ $item->barang?->nama ?? '-' }}</td>
                                    <td class="text-end">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada detail barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Detail Barang-->

                <hr class="border-gray-300 my-6" />

                <!--begin::Ringkasan Total-->
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-borderless fw-semibold">
                            <tr>
                                <td class="text-gray-600">Total Item</td>
                                <td class="text-end">{{ number_format($data->total_item ?? 0, 0, ',', '.') }} Item</td>
                            </tr>
                            <tr>
                                <td class="text-gray-600">Total Harga</td>
                                <td class="text-end">Rp {{ number_format($data->total_harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-gray-600">Potongan</td>
                                <td class="text-end text-danger">- Rp {{ number_format($data->potongan ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-top fw-bold fs-5">
                                <td class="text-gray-800">Grand Total</td>
                                <td class="text-end text-primary">
                                    Rp {{ number_format(($data->total_harga ?? 0) - ($data->potongan ?? 0), 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--end::Ringkasan Total-->


