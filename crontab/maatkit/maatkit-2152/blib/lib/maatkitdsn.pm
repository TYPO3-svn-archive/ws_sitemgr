package maatkitdsn;

our $VERSION = '2152';

1;

=pod

=head1 NAME

maatkitdsn - Data Source Names for maatkit

=head1 SYNOPSIS

 h=host,u=user,p=password,...

=head1 DESCRIPTION

This document describes how to specify a Data Source Name (DSN) for L<maatkit>.
Maatkit uses DSNs to specify how to create a DBD connection to a MySQL server.
The maatkit tools that have command-line arguments such as -u or -p use them to
create a DSN behind the scenes, then use the DSN to connect to MySQL.

A DSN is a string of key=value parts separated by commas.  The possible keys are
shown later in this document.  You can also get a quick synopsis from the --help
output of many of the maatkit tools.

=head1 PARTS

Many of the tools add more parts to DSNs for special purposes, and sometimes
override parts to make them do something slightly different.  However, all the
tools support at least the following:

=over

=item A

Specifies the default character set for the connection.

Enables character set settings in Perl and MySQL.  If the value is C<utf8>, sets
Perl's binmode on STDOUT to utf8, passes the C<mysql_enable_utf8> option to
DBD::mysql, and runs C<SET NAMES UTF8> after connecting to MySQL.  Any other
value sets binmode on STDOUT without the utf8 layer, and runs C<SET NAMES> after
connecting to MySQL.

Unfortunately, there is no way from within Perl itself to specify the client
library's character set.  C<SET NAMES> only affects the server; if the client
library's settings don't match, there could be problems.  You can use the
defaults file to specify the client library's character set, however.

=item D

Specifies the connection's default database.

=item F

Specifies a defaults file the client library should read.  The maatkit tools all
read the [mysql] section within the defaults file.  If you omit this, the
standard defaults files will be read in the usual order.  "Standard" varies from
system to system, because the filenames to read are compiled into the client
library.  On Debian systems, for example, it's usually /etc/mysql/my.cnf,
~/.my.cnf, and then /usr/etc/my.cnf.  If you place the following into ~/.my.cnf,
maatkit will Do The Right Thing:

 [mysql]
 user=your_user_name
 pass=secret

Omitting this part is usually the right thing to do.  As long as you have
configured your ~/.my.cnf correctly, that will result in maatkit connecting
automatically without needing a username or password.

You can also specify a default character set in the defaults file.  Unlike the
L<"A"> part described above, this will actually instruct the client library
(DBD::mysql) to change the character set it uses internally, which cannot be
accomplished any other way as far as I know, except for C<utf8>.

=item P

Port number to use for the connection.  Note that the usual special-case
behaviors apply: if you specify C<localhost> as your hostname on Unix systems,
the connection actually uses a socket file, not a TCP/IP connection, and thus
ignores the port.

=item S

Socket file to use for the connection (on Unix systems).

=item h

Hostname or IP address for the connection.

=item p

Password to use when connecting.

=item u

User for login if not current user.

=back

=head1 BAREWORD

Many of the tools will let you specify a DSN as a single word, without any
key=value syntax.  This is called a 'bareword'.  How this is handled is
tool-specific, but it is usually interpreted as the L<"h"> part.

=head1 DEFAULT PROPAGATION

Many tools will let you propagate values from one DSN to the next, so you don't
have to specify all the parts for each DSN.  For example, if you want to specify
a username and password for each DSN, you can connect to three hosts as follows:

 h=host1,u=fred,p=wilma host2 host3

This is tool-specific.

=cut
