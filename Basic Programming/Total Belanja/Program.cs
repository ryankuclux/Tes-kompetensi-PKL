using System;

class Program
{
    static void Main()
    {
        // Harga produk
        int hargaIndomie = 3000;
        int hargaTelur = 1500;
        int hargaKopi = 1000;
        int hargaSusu = 2500;

        // Jumlah embelian produk
        int jumlahKopi = 2;
        int jumlahTelur = 3;
        int jumlahIndomie = 1;
        int jumlahSusu = 0;

        // Hitung total belanja
        int totalBelanja = (jumlahIndomie * hargaIndomie) +
                           (jumlahTelur * hargaTelur) +
                           (jumlahKopi * hargaKopi) +
                           (jumlahSusu * hargaSusu);

        // Tampilkan total belanja
        Console.WriteLine("Total belanja adalah: Rp. " + totalBelanja);
    }
}