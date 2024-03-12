@extends('emails.app')
@section('content')

    <body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
            style="mso-table-lspace: 0; mso-table-rspace: 0; background-color: #fff;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                            role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="500">
                                            <tbody>
                                                <tr>
                                                    <th class="column"
                                                        style="mso-table-lspace: 0; mso-table-rspace: 0; font-weight: 400; text-align: left; vertical-align: top;"
                                                        width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="image_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td style="width:100%; padding: 5px; text-align: center;">
                                                                    <div style="line-height: 10px;">
                                                                        {{-- <img src="https://api.involuntir.com/images/logo/logo_involuntir_1.png" style="display: inline-block;" /> --}}
                                                                    </div>
                                                                </td>
                                                        </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block" role="presentation"
                                                            style="mso-table-lspace: 0; mso-table-rspace: 0; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td
                                                                    style="padding-top:32px;padding-right:10px;padding-bottom:24px;padding-left:10px;">
                                                                    <div style="font-family: Arial, sans-serif">
                                                                        <div
                                                                            style="font-size: 14px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000000; line-height: 1.2;">
                                                                            <p style="margin: 0;">Pengajuan barang dari
                                                                                <strong>{{ $nama_pemohon }}</strong>,
                                                                            </p>
                                                                            <br>
                                                                            <p style="margin: 0;">Pengajuan barang<strong
                                                                                    style="color:rgb(9, 9, 9);"> dari</strong>
                                                                                cabang
                                                                                <strong>{{ $cabang }} </strong>
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;"><strong>Rincian
                                                                                    Pengajuan</strong></p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <p style="margin: 0;">Nama barang :<strong>
                                                                                <strong>{{ $barang }}</strong><br />
                                                                            <p style="margin: 0;">Jumlah Barang :
                                                                                <strong>{{ $jumlah }}</strong><br />Catatan :
                                                                                <strong>{{ $catatan }}</strong>
                                                                            </p>
                                                                            <p
                                                                                style="margin: 0; mso-line-height-alt: 16.8px;">
                                                                                <br />
                                                                            </p>
                                                                            <a href="http://localhost:3000/admin/permintaan-barang" style="text-decoration: none; color: #000000; display: inline-block; padding: 10px; background-color: #FFFFFF; border: 1px solid #CCCCCC; border-radius: 5px;">Lihat detail</a>
                                                                        </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0" class="divider_block" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                            <tr>
                                                                <td>
                                                                    <div align="center">
                                                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0; mso-table-rspace: 0;" width="100%">
                                                                            <tr>
                                                                                <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #C4C4C4;">
                                                                                    {{-- <a href="http://localhost:3000/admin/permintaan-barang" style="text-decoration: none; color: #000000; display: inline-block; padding: 10px; background-color: #FFFFFF; border: 1px solid #CCCCCC; border-radius: 5px;">Lihat detail</a> --}}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                                                                          
                                                       
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table><!-- End -->
    </body>
@endsection
