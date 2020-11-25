<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        // $produk = $this->produkModel->findAll();

        $data = [
            'judul' => 'Daftar Produk',
            'produk' => $this->produkModel->getProduk()
        ];

        return view('produk/index', $data);
    }

    public function detail($id)
    {
        $produl = $this->produkModel->getProduk($id);
    }

    public function tambah()
    {
        $data = [
            'judul' => 'Tambah Data Produk',
            'validation' => \Config\Services::validation()
        ];

        return view('produk/tambah', $data);
    }

    public function save()
    {

        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required|is_unique[produk.nama_produk]',
                'errors' => [
                    'required' => 'Nama produk harus diisi',
                    'is_unique' => 'Nama produk sudah terdaftar'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/produk/tambah')->withInput()->with('validation', $validation);
        }

        $this->produkModel->save([
            'nama_produk' => $this->request->getVar('nama_produk'),
            'keterangan' => $this->request->getVar('keterangan'),
            'harga' => $this->request->getVar('harga'),
            'jumlah' => $this->request->getVar('jumlah')
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil ditambahkan');

        return redirect()->to('/produk');
    }

    public function hapus($id)
    {
        $this->produkModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil dihapus');

        return redirect()->to('/produk');
    }

    public function ubah($id)
    {
        $data = [
            'judul' => 'Ubah Data Produk',
            'validation' => \Config\Services::validation(),
            'produk' => $this->produkModel->getProduk($id)
        ];

        return view('produk/ubah', $data);
    }

    public function update($id)
    {

        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required|is_unique[produk.nama_produk]',
                'errors' => [
                    'required' => 'Nama produk harus diisi',
                    'is_unique' => 'Nama produk sudah terdaftar'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/produk/ubah')->withInput()->with('validation', $validation);
        }

        $this->produkModel->save([
            'id' => $id,
            'nama_produk' => $this->request->getVar('nama_produk'),
            'keterangan' => $this->request->getVar('keterangan'),
            'harga' => $this->request->getVar('harga'),
            'jumlah' => $this->request->getVar('jumlah')
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil diubah');

        return redirect()->to('/produk');
    }
}
