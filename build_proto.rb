#
# Fetches specified proto files from the artifact repository.
#
TOKEN_PROTOS_VER = "1.3.9"
RPC_PROTOS_VER = "1.2.0"

require 'open-uri'
require 'fileutils'

def fetch_protos()
    def download(path, name, type, version)
        file = "#{name}-#{type}-#{version}.jar"
        puts("Downloading #{file} ...")

        m2path = ENV["HOME"] + "/.m2/repository/#{path}/#{name}-#{type}/#{version}/#{file}"
        if File.file?(m2path) then
            FileUtils.cp(m2path, file)
        else
            url = "https://token.jfrog.io/token/libs-release/#{path}/#{name}-#{type}/#{version}/#{file}"
            open(file, 'wb') do |file|
                file << open(url).read
            end
        end
        file
    end

    system("rm protos/common/**.proto")
    system("rm -rf protos/external")

    system("mkdir -p protos/external")
    file = download("io/token/proto", "tokenio-proto", "external", TOKEN_PROTOS_VER)
    puts("unzipping #{file}")
    system("unzip -d protos/external -o #{file} 'gateway/*.proto'")
    system("rm -f #{file}");

    system("mkdir -p protos/common")
    file = download("io/token/proto", "tokenio-proto", "common", TOKEN_PROTOS_VER)
    puts("unzipping #{file}")
    system("unzip -d protos/common -o #{file} '**.proto'")
    system("rm -f #{file}");

    file = download("io/token/rpc", "tokenio-rpc", "proto", RPC_PROTOS_VER)
    system("unzip -d protos/ -o #{file} '*.proto'")
    system("rm -f #{file}");
end

#
# Generates PHP code for the protos.
#
def generate_protos_cmd(src, path_to_protos, out_dir)
    #Provide path to gRPC extension
    protoc_dir = "./tools/" + ((RUBY_PLATFORM.include?"linux") ? "linux_x64" : "macosx_x64");
    protoc = "#{protoc_dir}/protoc"
    plugin = "#{protoc_dir}/grpc_php_plugin"
    
    result = <<-CMD
       mkdir -p #{out_dir}
       #{protoc} \
       --plugin=protoc-gen-grpc=#{plugin} \
           --php_out=#{out_dir} \
           --grpc_out=#{out_dir} \
           -I #{src}/common \
           -I #{src}/external \
           -I #{src} \
           -I . \
           #{src}/#{path_to_protos}/*.proto
    CMD
    result
end

# Fetch the protos.
fetch_protos();

# Build the command that generates the protos.
dir = "./lib/Proto"
system("rm -rf #{dir}/Google");
system("rm -rf #{dir}/GPBMetadata");
system("rm -rf #{dir}/Io");
system("mkdir #{dir}");

Dir.chdir("./protos");
protoDirs = Dir["common/**/"]
protoDirs = protoDirs.select do |elem| !elem.start_with?("common/google") end # ignore generated files
Dir.chdir("..");

gencommand = generate_protos_cmd("./protos", "common/google/api", dir) +
             generate_protos_cmd("./protos", "extensions", dir) +
             generate_protos_cmd("./protos", "external/gateway", dir);

for protoDir in protoDirs
    # remove trailing /
    gencommand = gencommand + generate_protos_cmd("./protos", protoDir[0..protoDir.length-2], dir);
end

system(gencommand);
