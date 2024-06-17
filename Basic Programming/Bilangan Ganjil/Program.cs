using System;

class Program
{
    static void Main()
    {
        // Minta input dari pengguna
        Console.Write("Masukkan nilai n: ");
        int n = int.Parse(Console.ReadLine());

        // Hitung jumlah bilangan ganjil
        int jumlahBilanganGanjil = 0;
        for (int i = 1; i <= n; i++)
        {
            if (i % 2 != 0)
            {
                jumlahBilanganGanjil++;
            }
        }

        // Tampilkan hasil
        Console.WriteLine("Jumlah bilangan ganjil dari 1 hingga " + n + " adalah: " + jumlahBilanganGanjil);
    }
}