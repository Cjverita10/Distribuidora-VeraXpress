using System;
using System.Collections.Generic;

namespace VeraXpressLogistics
{
    public interface IProducto
    {
        string ObtenerNombre();
        decimal CalcularPrecioFinal();
        string ObtenerDetalleLogistica();
    }

    public class ProductoEstandard : IProducto
    {
        private string _nombre;
        private decimal _precioBase;

        public ProductoEstandard(string nombre, decimal precioBase)
        {
            _nombre = nombre;
            _precioBase = precioBase;
        }

        public string ObtenerNombre() => _nombre;
        public decimal CalcularPrecioFinal() => _precioBase;
        public string ObtenerDetalleLogistica() => "Despacho Estándar (Empaque de cartón sin recargo)";
    }

    public class ProductoFragil : IProducto
    {
        private string _nombre;
        private decimal _precioBase;
        private decimal _recargoEmpaque = 25000m;

        public ProductoFragil(string nombre, decimal precioBase)
        {
            _nombre = nombre;
            _precioBase = precioBase;
        }

        public string ObtenerNombre() => _nombre;
        public decimal CalcularPrecioFinal() => _precioBase + _recargoEmpaque;
        public string ObtenerDetalleLogistica() => "Producto Delicado / Pantalla (Empaque reforzado + seguro: $25.000 COP)";
    }

    public class ProductoPesado : IProducto
    {
        private string _nombre;
        private decimal _precioBase;
        private decimal _fleteCarga = 60000m;

        public ProductoPesado(string nombre, decimal precioBase)
        {
            _nombre = nombre;
            _precioBase = precioBase;
        }

        public string ObtenerNombre() => _nombre;
        public decimal CalcularPrecioFinal() => _precioBase + _fleteCarga;
        public string ObtenerDetalleLogistica() => "Carga Pesada (>20 kg) (Flete especial + 2 operarios: $60.000 COP)";
    }

    public static class FabricaLogistica
    {
        public static IProducto CrearProducto(string nombre, decimal precioBase, double pesoKg, bool esDelicado)
        {
            if (pesoKg > 20)
            {
                return new ProductoPesado(nombre, precioBase);
            }

            if (esDelicado)
            {
                return new ProductoFragil(nombre, precioBase);
            }

            return new ProductoEstandard(nombre, precioBase);
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            var catalogoPrueba = new List<Dictionary<string, object>>
            {
                new Dictionary<string, object>
                {
                    { "nombre", "Radio Portátil Bluetooth" },
                    { "precio", 65000m },
                    { "peso", 0.8 },
                    { "delicado", false },
                    { "nota", "Hasta 10 kg y no delicado -> Despacho estándar en caja de cartón" }
                },
                new Dictionary<string, object>
                {
                    { "nombre", "Smart TV 55 OLED 4K" },
                    { "precio", 1800000m },
                    { "peso", 12.0 },
                    { "delicado", true },
                    { "nota", "Producto delicado (pantalla) -> Empaque reinforced con seguro" }
                },
                new Dictionary<string, object>
                {
                    { "nombre", "Nevecón No Frost 520L" },
                    { "precio", 3200000m },
                    { "peso", 80.0 },
                    { "delicado", false },
                    { "nota", "Pesa más de 20 kg -> Aplica flete de carga pesada" }
                }
            };

            foreach (var item in catalogoPrueba)
            {
                string nombre = (string)item["nombre"];
                decimal precio = (decimal)item["precio"];
                double peso = (double)item["peso"];
                bool delicado = (bool)item["delicado"];
                string nota = (string)item["nota"];

                IProducto producto = FabricaLogistica.CrearProducto(nombre, precio, peso, delicado);

                Console.WriteLine("=================================================");
                Console.WriteLine($"PRODUCTO: {producto.ObtenerNombre()} [{peso} kg]");
                Console.WriteLine($"Precio Base: ${precio:N0} COP");
                Console.WriteLine($"¿Es Delicado?: {(delicado ? "Sí" : "No")}");
                Console.WriteLine($"Criterio: {nota}");
                Console.WriteLine($"Detalle Despacho: {producto.ObtenerDetalleLogistica()}");
                Console.WriteLine($"TOTAL LIQUIDADO: ${producto.CalcularPrecioFinal():N0} COP");
                Console.WriteLine("=================================================\n");
            }
        }
    }
}
