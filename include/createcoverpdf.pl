#!/usr/bin/perl
use PDF::API2::Lite;
use PDF::API2;
use GD::Barcode;
use Cwd 'abs_path';
use Cwd;
use File::Basename;
use DBI;
use constant mm => 25.4 / 72;
sub dbconn 
	{
	my $dsn = 'DBI:mysql:editus:localhost';
	my $db_user_name = 'editus';
	my $db_password = 'eeX9dei';
	my $dbh = DBI->connect($dsn, $db_user_name, $db_password);
	$dbh->{'mysql_enable_utf8'} = 1;
	$dbh->do('SET NAMES utf8');
	return $dbh;
	}
my $dirname = abs_path($0);
$dirname  = dirname($dirname);
my $srcfname = $ARGV[0];
my $isbn=$ARGV[1], if $ARGV[1];
my $jpgfname;
my $pdffname;
if ($ARGV[0] =~ /\.jpg$/)
	{
	$jpgfname = $srcfname;
	}
else 
	{
	$jpgfname = $srcfname;
	$jpgfname =~s/\..{3,4}$/\.jpg/gi;
	`/usr/bin/convert -density 300 $srcfname -background white -flatten -alpha off $jpgfname`;
	}
$pdffname=$srcfname;
$pdffname =~s/\..{3,4}$/\_nobox.pdf/gi;
$bcfname=$srcfname;
$bcfname =~s/\..{3,4}$/\_barcode.pdf/gi;
$bcfname =~s/_cover//gi;
$bcfname =~ /\d{3,}/;
`/usr/bin/python $dirname/createbarcodepdf.py $bcfname $&`;
if ($isbn) 
	{
	`/usr/bin/python $dirname/createbarcodepdf.py $bcfname $isbn`;
	}
else
	{ 
	`/usr/bin/python $dirname/createbarcodepdf.py $bcfname $&`;
	}
my $params = `/usr/bin/identify -format "%w %h" $jpgfname`;
my ($w,$h) = split(' ',$params);
my @ordernum=split("_",$pdffname);
my @on=split('/',@ordernum[0]);
my $ordnum=pop @on;
#open (MYFILE, '>/tmp/ord.txt');
#			print MYFILE "$ordnum\n";
#			print MYFILE "$dirname\n";
#			close (MYFILE); 
my $dbh = dbconn();
			my $sth = $dbh->prepare(qq{select orderCover,orderSize from UsersOrders where orderId='$ordnum' limit 1});
   			$sth->execute();
    		my ($type,$psize) = $sth->fetchrow_array();
#open (MYFILE, '>/tmp/ord.txt');
#                       print MYFILE "$ordnum\n";
#                       print MYFILE "===\n";
#                       close (MYFILE); 


$pdf = PDF::API2::Lite->new;
$page = $pdf->page($w*72/300,$h*72/300);
$img = $pdf->image_jpeg("$jpgfname");
$pdf->image($img,0,0,72/300);
$pdf->saveas("$pdffname");

$outname = $pdffname;
$outname =~s/_nobox//gi;

$pdfwbox = $pdffname;
$pdfwbox =~s/_nobox/_nobox_wbc/gi;
$y=10/mm;

if ($type eq "hard") {
$sth = $dbh->prepare(qq{select beforeWidth,beforeHeght from BindingCoverParam where (formatId='$psize' and CoverType='soft') limit 1});
                        $sth->execute();
my ($sw,$sh) = $sth->fetchrow_array();
$sth = $dbh->prepare(qq{select beforeWidth,beforeHeght from BindingCoverParam where (formatId='$psize' and CoverType='hard') limit 1});
                        $sth->execute();
my ($hw,$hh) = $sth->fetchrow_array();
#$w+=($hw-$sw);
#$h+=($hh-$sh);
#$xo2-=1000;
$y=($hh-$sh)/mm-$y+5/mm;

}

$pdf = PDF::API2->new();
$old = PDF::API2->open("$pdffname");
$old2 = PDF::API2->open("$bcfname");
$page = $pdf->importpage($old, 1);
$gfx = $page->gfx();
$xo2 = $pdf->importPageIntoForm($old2, 1);
$gfx->formimage($xo2,$w*72/300/2-60/mm-5/mm,$y,0.9); 
$pdf->saveas("$pdfwbox");
`/usr/bin/python $dirname/createcoverpdf_boxes.py $pdfwbox $outname`;
