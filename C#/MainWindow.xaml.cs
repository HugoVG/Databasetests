using System;
using System.Collections.Generic;
using System.Data;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using Microsoft.Win32;
using MySql.Data.MySqlClient;



namespace Database_Test
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        string img_path;

        public MainWindow()
        {
            InitializeComponent();

            

        }

        void Button_Click(object sender, RoutedEventArgs e)
        {
            string cs = @"server=;port=;userid=;database=";

            using var con = new MySqlConnection(cs);
            MySqlCommand cmd;
            FileStream fs;
            BinaryReader br;
            try
            {
                if (imgpather.Content.ToString() != "")
                {
                    string FileName = img_path;
                    byte[] ImageData;
                    fs = new FileStream(FileName, FileMode.Open, FileAccess.Read);
                    br = new BinaryReader(fs);
                    ImageData = br.ReadBytes((int)fs.Length);
                    br.Close();
                    fs.Close();
                    string CmdString = "INSERT INTO hugo2.products ( image, name_prod, prod_detail ) VALUES(@Image, @nameprod, @det)";
                    cmd = new MySqlCommand(CmdString, con);
                    cmd.Parameters.Add("@Image", MySqlDbType.LongBlob);
                    cmd.Parameters.Add("@nameprod", MySqlDbType.VarChar, 100);
                    cmd.Parameters.Add("@det", MySqlDbType.VarChar, 100);
                    cmd.Parameters["@nameprod"].Value = ProdNam.Text;
                    cmd.Parameters["@Image"].Value = ImageData;
                    cmd.Parameters["@det"].Value = ProdDet.Text;
                    con.Open();

                    int RowsAffected = cmd.ExecuteNonQuery();
                    if (RowsAffected > 0)
                    {
                        MessageBox.Show("Image saved sucessfully!");
                    }
                    con.Close();

                }
                else
                {
                    MessageBox.Show("Incomplete data!");
                }

            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
            finally
            {
                if (con.State == ConnectionState.Open)
                {
                    con.Close();
                }
            }

        }

        private void Findder_Click(object sender, RoutedEventArgs e)
        {
            OpenFileDialog openFileDialog = new OpenFileDialog();
            openFileDialog.Multiselect = false;
            openFileDialog.Filter = "Image files (*.png;*.jpeg)|*.png;*.jpeg|All files (*.*)|*.*";
            if (openFileDialog.ShowDialog() == true)
            {
                foreach (string filename in openFileDialog.FileNames)
                {
                    imgpather.Content = System.IO.Path.GetFileName(filename);
                    img_path = System.IO.Path.GetFullPath(filename);
                    Debug.Print(img_path);
                }
            }
        }
    }
}
