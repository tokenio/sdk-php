#
# Fetches specified proto files from the artifact repository.
#
TOKEN_PROTOS_VER = "1.1.23"
RPC_PROTOS_VER = "1.1.0"

require 'open-uri'

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

    system("rm protos/common/*.proto")
    system("rm -rf protos/external")

    system("mkdir -p protos/external")
    file = download("io/token/proto", "tokenio-proto", "external", TOKEN_PROTOS_VER)
    puts("unzipping #{file}")
    system("unzip -d protos/external -o #{file} 'gateway/*.proto'")
    system("rm -f #{file}");

    system("mkdir -p protos/common")
    file = download("io/token/proto", "tokenio-proto", "common", TOKEN_PROTOS_VER)
    puts("unzipping #{file}")
    system("unzip -d protos/common -o #{file} '*.proto'")
    system("unzip -d protos/common -o #{file} 'google/api/*.proto'")
    system("rm -f #{file}");

    file = download("io/token/rpc", "tokenio-rpc", "proto", RPC_PROTOS_VER)
    system("unzip -d protos/ -o #{file} '*.proto'")
    system("rm -f #{file}");
end

#
# Generates Objective-C code for the protos.
#
def generate_protos_cmd(path_to_protos, out_dir)
    # Base directory where the .proto files are.
    src = "./protos"

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


def fix_namespaces(out_dir)
    Dir.glob("#{out_dir}/**/*") do |file_name|
        if(!File.directory?(file_name))
            file_contents = File.read(file_name);
            new_contents = file_contents.gsub("GPBMetadata", "Io\\Token\\GPBMetadata")
            File.open(file_name, "w") {|file| file.puts new_contents }
        end
    end
end

# Fetch the protos.
fetch_protos();

# Build the command that generates the protos.
dir = "./lib/Proto"
system("rm -rf #{dir}/Google");
system("rm -rf #{dir}/GPBMetadata");
system("rm -rf #{dir}/Io");
system("mkdir #{dir}");

gencommand = generate_protos_cmd("common", dir)+
 generate_protos_cmd("common/google/api", dir) +
 generate_protos_cmd("extensions", dir) +
 generate_protos_cmd("external/gateway", dir);

system(gencommand);
fix_namespaces(dir);