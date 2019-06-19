<h1>Okul Otomasyonu</h1>

<h2>Proje İçeriği</h2>

Geliştirilen yazılımda anasayfada kullanıcı giriş yapma bölümü bulunmaktadır. Aynı bölümden hem yetkili kullanıcı hemde öğretmenler giriş yapmaktadır. Giriş yaptıktan sonra yetkiye uygun sayfaya yönlendirme yapar ve elle url girilme ihtimaline karşı gerekli session kontrolleri yapılmıştır. Yönetici panelinde Yeni bir öğretmen eklenebilir yada var olan öğretmenlere yeni ders eklenebilir. Öğretmenlerin panelinde ise öğretmenin verdiği dersler listesi görünür, bu liste içerisinden ders seçildiğinde öğrenci listesi getirilmektedir. Öğretmen öğrenci listesinden dersine yeni öğrenci ekleyebilir. Öğrencilerin notlarını düzenlediğinde otomatik olarak kayıt edilmektedir herhangi bir işlem yapmaya gerek yoktur. Ortalamayı otomatik hesaplamaktadır. Yazdır butonu ile seçili olan dersin öğrenci listesi, yazdırmaya uygun formatta yazıcıya gönderilir. Çıkış butonları ile sessionlar sonlandırılır.

<h2>Projeden Beklenenler</h2>

1 okuldaki 1 sınıfın 5 ayrı dersi için 5 ayrı öğretim elemanı vardır. Bu öğretim elemanlarının isimleri, kullanıcı adları ve şifreleri 1 table ile tutulacaktır. Öğrencilerin numara, isimleri ve derslerden alacakları vize final notları ayrı tablolarda tutulacaktır. Buna göre öğretim elemanları kendi şifreleri ile girdiklerinde, kendi sınıflarına öğrenci kaydedebilecek, notlarını girebilecek ve öğrencilerin durumlarını hesaplattırabileceklerdir. Ayrıca öğretim elemanları istenildiği zaman kendi derslerinin tablosunun o andaki durumunu çıktı olarak alabileceklerdir. Burada tanımlanan yetkili kullanıcı sisteme öğretim elemanı ve şifre tanımlama yetkileri ile donatılmış olacaktır.


<h2>Veritabanı Tabloları</h2>

```bash

--
-- `users` : Yetkili kullanıcılar ve öğretmenlerin kayıtlı olduğu tablodur.
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT 'isim',
  `username` varchar(20) NOT NULL COMMENT 'kullanci adi',
  `password` varchar(20) NOT NULL COMMENT 'sifre',
  `auth` tinyint(4) NOT NULL COMMENT 'yetki-> 0: yetkili 1: ogretmen',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin5;


--
-- `students`: Okuldaki tüm öğrencilerin kayıtlı oolduğu tablo.
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin5;


--
-- `lessons`: Derslerin tutulduğu tablo. Derslerin isimleri ve dersin hocasının idsini tutar.
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_name` text NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin5;


--
-- `student_taking_lasson`: Öğrencilerin aldığı dersleri ve notlarını tutan tablo.
--

CREATE TABLE `student_taking_lasson` (
  `students_id` int(11) NOT NULL,
  `lessons_id` int(11) NOT NULL,
  `vize_note` int(11) DEFAULT NULL,
  `final_note` int(11) DEFAULT NULL,
  `letter_note` varchar(2) DEFAULT NULL,
  FOREIGN KEY (`students_id`) REFERENCES `students` (`id`),
  FOREIGN KEY (`lessons_id`) REFERENCES `lessons` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

```

<p>
	**Not:** Database myo_ders.sql dosyasında mevcuttur. Veritabanı kullanıcı adı root şifre boş olacak şekilde ayarlanmıştır.
</p>

<h2>Ekran Görüntüleri</h2>

<h3>Giriş Paneli</h3>

![indexPanel](/screenshots/index.png)


<h3>Kullanıcı Paneli 1</h3>

![KulaniciPanel1](/screenshots/user1.png)

<h3>Kullanıcı Paneli 2</h3>

![KulaniciPanel2](/screenshots/user2.png)

<h3>Kullanıcı Paneli 3</h3>

![KulaniciPanel3](/screenshots/user3.png)

<h3>Root Paneli</h3>

![RootPanel](/screenshots/root.png)

