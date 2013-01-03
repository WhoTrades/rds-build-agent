#!/bin/sh

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

unset GIT_DIR
unset GIT_WORK_DIR

: ${NAME=$1}
: ${VERBOSE="no"}
: ${TMPDIR="/var/tmp"}

: ${VERSION="`date "+%Y.%m.%d.%H.%M"`"}
: ${RELEASE="1"}

NAME=`basename $NAME`

if isnull $NAME; then
  echo "$0 packagename"
  exitf
fi

srcdir=`printf %s/../%s $SCRIPT_PATH $NAME`
specfile=`printf %s/%s.spec $TMPDIR $NAME`

cat <<EOF > $specfile || exit 1
%define __os_install_post %{nil}

Name:           $NAME
Version:        $VERSION
Release:        $RELEASE%{?dist}
Summary:        WhoTrades.com $NAME sources

Group:          Applications/WWW
License:        Proprietary
URL:            http://whotrades.com
BuildRoot:      %{_tmppath}/%{name}-%{version}-%{release}-root-%(%{__id_u} -n)
BuildArch:      noarch

BuildRequires:  php-pear-phing

%description
WhoTrades.Com: $NAME sources.

%prep


%build

%install
rm -rf %{buildroot}
mkdir -p %{buildroot}%{_localstatedir}/pkg/$NAME-$VERSION-$RELEASE
phing -Dname=$NAME -Ddestdir=%{buildroot}%{_localstatedir}/pkg/$NAME-$VERSION-$RELEASE -f $srcdir/build.xml


%clean
rm -rf %{buildroot}


%files
%defattr(-,release,release,-)
%verify(not md5 mtime size) %{_localstatedir}/pkg/$NAME-$VERSION-$RELEASE


%changelog
* `date "+%a %b %d %Y"` Package Builder <vdm+release@whotrades.net> - $VERSION-$RELEASE
- RPM Package.
EOF



trap "{ rm -f $specfile; }" EXIT

rpmbuild="rpmbuild -ba $specfile"
if verbose; then
  rpmbuild="rpmbuild"
else
  rpmbuild="rpmbuild --quiet"
fi

$rpmbuild -ba $specfile
retval=$?

if [ $retval -eq 0 ]; then
  echo ${GREEN}$NAME $VERSION-$RELEASE${NORMAL}
fi

exit $retval
