# silik_bali
silik bali app


#Config GitHub

- ssh-keygen
- cat ~/.ssh/id_rsa.pub
- Copy key ke profile GitHub
- nano .git/config
- Rubah url origin menjadi ssh repository
- git push origin <branch>

# Vendor Composer install
- composer install

#vendor di silik/third_party/Google/vendor perlu di buat ulang

 
#Create a Migration
- php index.php migrate make create_your_table_name

Open the migration file that was created in the application/migrations directory. 

#env
APP_NAME='SASANDU'
APP_DETAIL='Sistem Layanan Terpadu BPMP Provinsi NTT'
DB_HOST='localhost'

DB_USER_MASTER=''
DB_PWD_MASTER=''
DB_NAME_MASTER=''

DB_USER_TRANSAKSI=''
DB_PWD_TRANSAKSI=''
DB_NAME_TRANSAKSI_2024=''

PREFIX_HOST='u146834964_'
APP_TYPE='prod'

#value config sesuai format penulisan contoh seperti yang sudah ada
INSTANSI_NAME='Balai Penjaminan Mutu Pendidikan Provinsi Nusa Tenggara Timur'
INSTANSI_SHORT_NAME='BPMP NTT'
INSTANSI_SLOGAN='Selalu Jaya!!'

BGP_CONFIG_1='BPMP NTT'
BGP_CONFIG_2='Balai Penjaminan Mutu Pendidikan Provinsi Nusa Tenggara Timur'
BGP_CONFIG_3='Balai Penjaminan Mutu Pendidikan Provinsi NTT'
BGP_CONFIG_4='BPMP NTT'
BGP_CONFIG_5='BPMP NTT'

DEFAULT_PROVINSI='Nusa Tenggara Timur'
DEFAULT_KABUPATEN='Kupang'
SLOGAN_APP='-'
START_YEAR='2024'

