using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using HWIDgbr;

namespace cSharpSerialLock
{
    public partial class Form1 : Form
    {

        bool check;
        string hwid;

        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            check = false;
            hwid = HWDI.GetMachineGuid();
            textBox2.Text = hwid;

            if (Properties.Settings.Default.Installed == true)
            {
                textBox1.Text = Properties.Settings.Default.Serial;
                timer1.Interval = 1;
                timer1.Start();
                check = true;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            check = true;
            button1.Enabled = false;
            webBrowser1.Navigate("http://localhost/serial/serialcheck.php?serial=" + textBox1.Text + "&hwidin=" + textBox2.Text + "&submit=Submit");
        }

        private void webBrowser1_DocumentCompleted(object sender, WebBrowserDocumentCompletedEventArgs e)
        {
            if (check == true)
            {
                if (webBrowser1.DocumentText.Contains("0"))
                {
                    check = false;
                    timer1.Stop();
                    button1.Enabled = true;
                    MessageBox.Show("Wrong HWID");
                }
                else if (webBrowser1.DocumentText.Contains("1"))
                {
                    check = false;
                    timer1.Stop();
                    button1.Enabled = true;
                    Properties.Settings.Default.Serial = textBox1.Text;
                    Properties.Settings.Default.Installed = true;
                    Properties.Settings.Default.Save();
                    MessageBox.Show("All info correct!");
                }
                else if (webBrowser1.DocumentText.Contains("2"))
                {
                    check = false;
                    timer1.Stop();
                    button1.Enabled = true;
                    MessageBox.Show("HWID field left empty");
                }
                else if (webBrowser1.DocumentText.Contains("3"))
                {
                    check = false;
                    timer1.Stop();
                    button1.Enabled = true;
                    MessageBox.Show("No serial with that key");
                }
            }
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            webBrowser1.Navigate("http://localhost/serial/serialcheck.php?serial=" + textBox1.Text + "&hwidin=" + textBox2.Text + "&submit=Submit");
        }
    }
}
