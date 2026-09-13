@extends('layouts.admin')

@section('page-title', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Total Bencana Aktif</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">20</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Laporan Pending</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">5</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Wilayah Terdampak</p>
        <p class="text-3xl font-bold text-green-700 mt-1">13 <span class="text-lg font-medium">Kab/Kota</span></p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Total Pengguna</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">48</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-900">Ringkasan Aktivitas Sistem Terakhir</h2>
    </div>

    <table class="w-full text-left text-sm">
        <thead>
            <tr class="text-gray-500 border-b border-gray-100">
                <th class="px-6 py-3">Waktu</th>
                <th class="px-6 py-3">Aktivitas</th>
                <th class="px-6 py-3">Oleh</th>
                <th class="px-6 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $log = [
                    ['waktu' => 'Hari ini, 10:45', 'aktivitas' => 'Menambahkan data bencana Banjir di Kab. Banjar', 'oleh' => 'Admin Operator'],
                    ['waktu' => 'Hari ini, 09:12', 'aktivitas' => 'Verifikasi laporan warga terkait Karhutla di Tanah Laut', 'oleh' => 'Super Admin'],
                    ['waktu' => 'Kemarin, 16:30', 'aktivitas' => 'Pembaruan kuota logistik posko pengungsian Martapura', 'oleh' => 'Admin Operator'],
                ];
            @endphp
            @foreach($log as $item)
                <tr class="border-b border-gray-50">
                    <td class="px-6 py-3.5 text-gray-500">{{ $item['waktu'] }}</td>
                    <td class="px-6 py-3.5 text-gray-800">{{ $item['aktivitas'] }}</td>
                    <td class="px-6 py-3.5 text-gray-700">{{ $item['oleh'] }}</td>
                    <td class="px-6 py-3.5">
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Terverifikasi</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="px-6 py-3 flex justify-between items-center text-sm text-gray-500">
        <span>Menampilkan {{ count($log) }} aktivitas terbaru</span>
        <a href="#" class="text-green-700 font-medium hover:underline">Lihat semua log aktivitas →</a>
    </div>
</div>
@endsection