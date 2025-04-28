<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkType::create([
            'type' => 'WIKA',
            'unit_name' => 'WIKA',
            'provision_text_before' => "Tidak menggunakan fasilitas bandara seperti Trolley untuk proses pengangkutan barang\nMematuhi peraturan dan tata tertib yang berlaku di Bandar Udara Internasional Hang Nadim - Batam\nMelaksanakan pekerjaan sesuai Timeline dan Rencana Pekerjaan\nSenantiasa menjaga kebersihan, ketertiban, dan keamanan selama kegiatan kerja\nEstetika dan kerapihan tempat pekerjaan harus tetap dijaga\n",
            'provision_text_after' => "Bersedia dihentikan sementara bilamana dianggap mengganggu sisi keamanan, sisi keselamatan pekerja dan pengguna jasa serta sisi pelayanan pada saat dilakukannya pekerjaan\nBersedia dilakukan monitoring dan pendampingan dari sisi Operasional, Keselamatan, dan Keamanan pada saat pekerjaan\nSenantiasa untuk berkoordinasi kepada unit Maintenance Bandar Udara Internasional Hang Nadim - Batam selama masa pekerjaan berlangsung serta segera melaporkan jika terdapat peralatan milik PT BIB yang terdampak akibat pekerjaan Pergantian Materi Informasi\nSurat Izin Kerja ini bukan merupakan izin masuk untuk melaksanakan pekerjaan di daerah keamanan bandara, agar dapat mengurus secara terpisah kepada unit Airport Security Bandar Udara Internasional Hang Nadim - Batam sebelum melaksanakan pekerjaan"
        ]);

        WorkType::create([
            'type' => 'Marketing',
            'unit_name' => 'Marketing',
            'provision_text_before' => "Tidak menggunakan fasilitas bandara seperti Trolley untuk proses pengangkutan barang\nPenanggung jawab dari Unit Marketing wajib agar dapat mendampingi selama kegiatan berlangsung\nMematuhi peraturan dan tata tertib yang berlaku di Bandar Udara Internasional Hang Nadim - Batam\nMelaksanakan pekerjaan sesuai Timeline dan Rencana Pekerjaan\nSenantiasa menjaga kebersihan, ketertiban, dan keamanan selama kegiatan kerja\nEstetika dan kerapihan tempat pekerjaan harus tetap dijaga\n",
            'provision_text_after' => "Bersedia dihentikan sementara bilamana dianggap mengganggu sisi keamanan, sisi keselamatan pekerja dan pengguna jasa serta sisi pelayanan pada saat dilakukannya pekerjaan\nBersedia dilakukan monitoring dan pendampingan dari sisi Operasional, Keselamatan, dan Keamanan pada saat pekerjaan\nSenantiasa untuk berkoordinasi kepada unit Maintenance Bandar Udara Internasional Hang Nadim - Batam selama masa pekerjaan berlangsung serta segera melaporkan jika terdapat peralatan milik PT BIB yang terdampak akibat pekerjaan Pergantian Materi Informasi\nSurat Izin Kerja ini bukan merupakan izin masuk untuk melaksanakan pekerjaan di daerah keamanan bandara, agar dapat mengurus secara terpisah kepada unit Airport Security Bandar Udara Internasional Hang Nadim - Batam sebelum melaksanakan pekerjaan"
        ]);

        WorkType::create([
            'type' => 'Maintenance',
            'unit_name' => 'Maintenance',
            'provision_text_before' => "Tidak menggunakan fasilitas bandara seperti Trolley untuk proses pengangkutan barang\nMematuhi peraturan dan tata tertib yang berlaku di Bandar Udara Internasional Hang Nadim - Batam\nMelaksanakan pekerjaan sesuai Timeline dan Rencana Pekerjaan\nSenantiasa menjaga kebersihan, ketertiban, dan keamanan selama kegiatan kerja\nEstetika dan kerapihan tempat pekerjaan harus tetap dijaga\n",
            'provision_text_after' => "Bersedia dihentikan sementara bilamana dianggap mengganggu sisi keamanan, sisi keselamatan pekerja dan pengguna jasa serta sisi pelayanan pada saat dilakukannya pekerjaan\nBersedia dilakukan monitoring dan pendampingan dari sisi Operasional, Keselamatan, dan Keamanan pada saat pekerjaan\nSenantiasa untuk berkoordinasi kepada unit Maintenance Bandar Udara Internasional Hang Nadim - Batam selama masa pekerjaan berlangsung serta segera melaporkan jika terdapat peralatan milik PT BIB yang terdampak akibat pekerjaan Pergantian Materi Informasi\nSurat Izin Kerja ini bukan merupakan izin masuk untuk melaksanakan pekerjaan di daerah keamanan bandara, agar dapat mengurus secara terpisah kepada unit Airport Security Bandar Udara Internasional Hang Nadim - Batam sebelum melaksanakan pekerjaan"
        ]);
    }
}
