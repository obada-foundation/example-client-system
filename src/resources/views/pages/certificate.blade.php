@extends('layouts.app-with-nav',[
    'page_title'        => 'Timestamp Certificate',
    'hide_breadcrumbs'  => true,
    'hide_h1'           => true
])


@section('head')
    <title>Timestamp Certificate</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/verify_index.css') }}"/>
@endsection


@section('scripts')
    <script src="{{ mix('/js/verify_index.js') }}"></script>
@endsection


@section('page_content')

    <div class="w-md-75 mx-auto">
        <h1 class="text-center">Timestamp Certificate</h1>
        <p class="text-center mb-5">This timestamp was created according to the the pNFT Standard being developed by the OBADA Foundation</p>

        <hr>

        <div class="row">
            <div class="col-sm-4">
                <h2 class="mb-0">Timestamp</h2>
            </div>
            <div class="col-sm-8">
                <h2 class="mb-0">Oct-14-2022 06:00:11 UTC</h2>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-sm-4">
                <img id="verification-qr" src="" alt="">
            </div>
            <div class="col-sm-8">
                <dl>
                    <dt>Hash:</dt>
                    <dd><small class="text-break">12a66ae17e2581e8ec3669524c3f992c00504ed97cc687757ca1dc37c9d228</small></dd>

                    <dt>Transaction:</dt>
                    <dd><small class="text-break"><a href="https://etherscan.io/tx/0xc284164f8d9a9e78ce26cda83917f41e65c155ab19e7544a3a2109b4d3ab7a">0xc284164f8d9a9e78ce26cda83917f41e65c155ab19e7544a3a2109b4d3ab7a</a></small></dd>

                    <dt>Root Hash:</dt>
                    <dd><small class="text-break">eeb18c0665766feac4fa8cce406f8362c5ff52bd7a332bb44f15aecd6107d0</small></dd>
                </dl>
            </div>
        </div>

        <p class="mt-4"><a id="verification-link" href="{{ route('verify') }}?verified=1">Click here to verify your timestamp.</a></p>

        <p class="">This certificate is only valid in combination with the original file and OBADA's
            open procedure. <br>More information on <a href="{{ route('verify') }}">{{ route('verify') }}</a>.</p>

        <hr class="mt-4 mb-4">

        <h2>Proof</h2>
        <p>The proof is necessary for the reproducibility of your document.</p>

        <xmp style="font-size: 0.75em; overflow: auto;">
<?xml version="1.0" encoding="UTF-8"?>
<node type="key" value="eeb18c0665766feac4fa8cce406f8362c5f52bd7a332bb44f15aecd6107d0f1">
  <left type="mesh" value="dc332ddf82e0b72d0c916dcd4223577a9c6bce5551260b5774719c556444fa7">
    <left type="mesh" value="8994124c2641630cae6d25ced5713c5864216ca2f2f1d8f9748dc8631d876d4">
      <left type="mesh" value="343bc867e559bfe0377434113b3e56cad4b2cf06fb1d57c9fd62b0642609fc8">
        <left type="mesh" value="140a95fd0d462b9b816dc5b1cf0251c7f4ad0e0e1f76cda33fac41a946b43af">
          <left type="mesh" value="c0a770ed76ab948134b1814fe6cfc56f65976c05a8ae04e76727f022d946dd1"/>
          <right type="mesh" value="04516892f9f35b154bf768ce94b60c643d2cb208af1c86d71f431f11c312e61">
            <left type="mesh" value="4b24304cc379c8189b80159a6f4400dfbf2a3904dc22d536941068a174f21b6"/>
            <right type="mesh" value="2c5d967db5d82896db86e3a3fd889c4bc29aaec8c6a60e10116d55a902f7873">
              <left type="mesh" value="c36c8f34d439ecb39918607f3d56bf57e088d949c954b6dad3e30a37b10646c"/>
              <right type="mesh" value="2d6972c88e256ae37a5a1459004a59c334352ff3859819d981c416940b22cbf">
                <left type="mesh" value="8adf98f5858df8df633a7cbfe3b365e1a7b4ab7871d2f2f44510c7125c51d50"/>
                <right type="mesh" value="b7a45e324993175e931eafe62e06ddda863ab69b609a39be210749f487203b7">
                  <left type="mesh" value="62c39d7da2037b1598e150c42d74441d0d2a7669e7fbaaf0280754036e43ebb"/>
                  <right type="mesh" value="b8b8e6acbeb8c13b2d9a24d560ffdd3e1dd79b7231275483c9ade4ea913a5b8">
                    <left type="mesh" value="ab7b4e9f5bd6e7a98af9d0de3516452d3f544b27aaae9f21745121c490c3b63"/>
                    <right type="mesh" value="dc2baf146333972d25e02a0b4801138b47b4fd582faad234cabbaaaeec47722">
                      <left type="mesh" value="c48e015020c85f419a6e886d3297186824568f9ac239739eb7afdbe48ca9d53">
                        <left type="mesh" value="8a6d3d2ec0e53b20976a42f7c1a0622ef03fcff190487353aa152d9f8102d83"/>
                        <right type="mesh" value="53b2b1328bb351a625b4eebb1b669c32682a982a78607260d9b2dd71fbeb00b">
                          <left type="mesh" value="df8758aa30b53108294167c5de7eed48a45dfd658eec6d5094794af9e7c05ee"/>
                          <right type="mesh" value="b71e385e52b6d9d9c6c52bcb0f878bbfef5e1467bc95a8610eab379870d43f0">
                            <left type="hash" value="12a66e17e2581e8ec3669524c3f992c00504ed97cc687757ca1dc37c9d22852"/>
                            <right type="mesh" value="12accc536f5479f08bd0c4ad279483236e9fb8660b4f52ce82ffb3c770d4c81"/>
                          </right>
                        </right>
                      </left>
                      <right type="mesh" value="abfddd7ba40284feef830eca6cb3c150242839eb80279ff529ffcdd72da03b5"/>
                    </right>
                  </right>
                </right>
              </right>
            </right>
          </right>
        </left>
        <right type="mesh" value="3a2121612b8f3d0a2fd32299e53734b246397bae39549a4d3d580bb7bda22bd"/>
      </left>
      <right type="mesh" value="ab83d81262145b1aee03dfeeacb060ad494f7fce4489e8e9689e033ba8b95c1"/>
    </left>
    <right type="mesh" value="ec411c8759973f5b0c3b62eef209844bc4a6bee7a15b26a65f3493a5f2faabf"/>
  </left>
  <right type="mesh" value="3a48aabb9d872dd46cfa983bcdf498f60cd7b304e18b8ed4973961e40ca5c2c"/>
</node>
        </xmp>

        <hr class="mt-4 mb-4">

        <h2>Verification</h2>

        <p>OBADA uses cryptographic methods to create tamper-proof timestamps for your data. Instead of backing up your data, OBADA embeds a cryptographic fingerprint in the blockchain. It is de facto impossible to deduce the content of your data from your fingerprint. Therefore, the data remains in your company and is not publicly accessible. All you need to do is send this fingerprint to OBADA via the interface. The integration of the RESTful API is very simple and convenient and allows all data to be easily tagged with a tamper-proof timestamp. This document shows the procedure and gives instructions for verifying a timestamp created with OBADA.</p>

        <h3>1. Determine the SHA-256 of your original file</h3>
        <p>There are numerous programs and libraries to calculate the SHA-256 of a file, such as <a href="https://md5file.com/calculator">MD5FILE</a>. Simply drag and drop or select your file, to retrieve the SHA-256 of your file.</p>

        <h3>2. Validate your proof</h3>
        <p>First, it must be verified that the hash of the original is part of the evidence. In order to check this, the proof can be opened with a conventional editor and its content can be searched for the hash. If the hash cannot be found, either the file was manipulated or the wrong evidence was selected.</p>

        <h3>3. Determine the root hash</h3>
        <p>The Merkle tree is a tree structure, that allows to organize the seed more efficient than a plain-text seed file. The tree is built from the bottom to the top and follows a defined schema. The value of a node is determined by the aggregated hash of its children.</p>
        <p class="text-break">
            Left child = <br><span style="color: deeppink;">a8eb9f308b08397df77443697de4959c156fd4c68c489995163285dbd3eeda</span> <br>
            Right child = <br><span style="color: darkorange;">ab95adaee8eb02219d556082a7f4fb70d19b8000097848112eb85b1d2fca8f</span> <br>
            Node = SHA-256(<span style="color: deeppink;">a8eb9f308b08397df77443697de4959c156fd4c68c489995163285dbd3eeda</span><span style="color: darkorange;">ab95adaee8eb02219d556082a7f4fb70d19b8000097848112eb85b1d2fca8f</span>) = 47e47c96302eeba62ed443dd0c89b3411bbddd2c1ff6bdfb1f833fa11e060b85
        </p>
        <p>This step is performed for all levels of the tree until the hash of the root has been calculated. If the hash of the root is identical as proof, the calculation was successful and the root hash is verified. The top hash corresponds to the root hash we embedded in the blockchain through a transaction. For a more detailed explanation of the Merkle tree, we want to refer to <a href="https://en.wikipedia.org/wiki/Merkle_tree">Wikipedia</a>.</p>

        <h3>4. Determine the pNFT address</h3>
        <p>Having determined the root hash in the previous step, we store this hash in a decentralized registry at a digital address for the physical asset.</p>

        <h3>5. Check the transactions</h3>
        <p>The respective log events must be searched for each transaction in this contract. These events are divided into topics. The root hash should be contained in a topic. Caution: Some services display the hashes with a 0x prefix. As soon as the transaction has been found, the block time is the actual tamper-proof timestamp. To simplify the search, we added the transaction to the certificate.</p>
    </div>

@endsection
